<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;

class PropertyReportAnalysis
{
    public function analyze(array $filters): array
    {
        $kind = $filters['kind']; $sizeField = $kind === 'house' ? 'square_feet' : 'acres';
        $size = $filters[$sizeField] ?? null;
        $query = DB::table('comparable_sales')->where('county_fips', $filters['county_fips'])->where('property_type', $kind)
            ->where('apn', '!=', $filters['apn'])->where('observed_at', '>=', now()->subDays($filters['lookback_days'])->toDateString())
            ->where('observed_at', '<=', now()->toDateString())->where('price', '>', 0);
        if ($size) { $query->whereBetween($sizeField, [$size * .75, $size * 1.25]); }
        if (isset($filters['min_price'])) { $query->where('price', '>=', $filters['min_price']); }
        if (isset($filters['max_price'])) { $query->where('price', '<=', $filters['max_price']); }
        $subject = PropertyCoordinates::pair($filters['latitude'] ?? null, $filters['longitude'] ?? null);
        $polygon = $filters['polygon'] ?? [];
        $rows = []; $seen = [preg_replace('/[^a-z0-9]/i', '', strtolower($filters['apn'])) => true];
        foreach ($query->orderByDesc('observed_at')->orderBy('id')->cursor() as $row) {
            if (!filter_var($row->source_url, FILTER_VALIDATE_URL) || !in_array(strtolower(parse_url($row->source_url, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) { continue; }
            $key = preg_replace('/[^a-z0-9]/i', '', strtolower($row->apn));
            if (isset($seen[$key])) { continue; }
            $point = PropertyCoordinates::pair($row->latitude, $row->longitude);
            $distance = $subject && $point ? $this->distance($subject, $point) : null;
            if (isset($filters['radius_miles']) && ($distance === null || $distance > $filters['radius_miles'])) { continue; }
            if ($polygon && (!$point || !$this->inside($point, $polygon))) { continue; }
            $seen[$key] = true;
            $rows[] = ['id' => $row->apn, 'address' => $row->address, 'city' => $row->city, 'price' => (float) $row->price,
                'acres' => $row->acres, 'square_feet' => $row->square_feet, 'status' => $row->status,
                'sold_date' => $row->sold_date, 'observed_at' => $row->observed_at, 'source' => $row->source, 'source_url' => $row->source_url,
                'latitude' => $row->latitude, 'longitude' => $row->longitude, 'distance_miles' => $distance];
            // Bound report size without claiming this is an exhaustive county export.
            if (count($rows) === 100) { break; }
        }
        usort($rows, fn ($a, $b) => ($a['distance_miles'] ?? INF) <=> ($b['distance_miles'] ?? INF));
        $rates = [];
        foreach ($rows as $r) {
            if ($r['status'] === 'sold' && $r['sold_date'] && $r['sold_date'] >= now()->subDays($filters['lookback_days'])->toDateString()
                && $r['sold_date'] <= now()->toDateString() && ($r[$sizeField] ?? 0) > 0) { $rates[] = $r['price'] / $r[$sizeField]; }
        }
        sort($rates); $count = count($rates);
        $median = $count ? ($rates[(int) floor(($count - 1) / 2)] + $rates[(int) floor($count / 2)]) / 2 : null;
        $estimate = $size && $count >= 3 ? round($size * $median, 2) : null;
        return ['records' => $rows, 'sold_count' => count(array_filter($rows, fn ($r) => $r['status'] === 'sold')),
            'for_sale_count' => count(array_filter($rows, fn ($r) => $r['status'] === 'for_sale')), 'eligible_sales' => $count,
            'unit' => $kind === 'house' ? 'sq ft' : 'acre', 'median_unit_price' => $count >= 3 ? round($median, 2) : null,
            'estimate' => $estimate, 'offer_percent' => $filters['offer_percent'],
            'offer' => $estimate !== null ? round($estimate * $filters['offer_percent'] / 100, 2) : null,
            'note' => 'Up to 100 recent client-imported records in this county, excluding the exact subject APN. Size matching uses 75%-125% of the entered subject size. Radius and polygon filters exclude records without usable coordinates. The indicative estimate needs at least three dated sold records and uses median sale price per unit multiplied by the user-entered subject size. Asking prices are excluded from the estimate. This is not a provider AVM or an appraisal. Missing dates, property condition, utilities and title still need independent review.'];
    }
    public function distance(array $a, array $b): float
    {
        $angle = sin(deg2rad($b[0] - $a[0]) / 2) ** 2 + cos(deg2rad($a[0])) * cos(deg2rad($b[0])) * sin(deg2rad($b[1] - $a[1]) / 2) ** 2;
        return round(3958.7613 * 2 * asin(sqrt(min(1, $angle))), 2);
    }
    public function inside(array $point, array $polygon): bool
    {
        [$y, $x] = $point; $inside = false; $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            [$yi, $xi] = $polygon[$i]; [$yj, $xj] = $polygon[$j];
            $cross = ($x - $xi) * ($yj - $yi) - ($y - $yi) * ($xj - $xi);
            if (abs($cross) < 1e-9 && $x >= min($xi, $xj) && $x <= max($xi, $xj) && $y >= min($yi, $yj) && $y <= max($yi, $yj)) { return true; }
            if (($yi > $y) !== ($yj > $y) && $x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi) { $inside = !$inside; }
        }
        return $inside;
    }
}
