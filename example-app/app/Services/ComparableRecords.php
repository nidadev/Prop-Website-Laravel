<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ComparableRecords
{
    public function forParcel(string $apn, string $fips, array $valuation, PrycdClient $client): array
    {
        $acres = $valuation['acres'] ?? null;
        if (!is_numeric($acres) || $acres <= 0) {
            return ['records' => [], 'note' => 'Parcel acreage was not supplied; comparable matching needs review.'];
        }
        $min = round($acres * 0.5, 5); $max = round($acres * 2, 5);
        $records = DB::table('comparable_sales')->where('county_fips', $fips)->where('property_type', 'land')
            ->where('apn', '!=', $apn)->whereBetween('acres', [$min, $max])
            ->where('observed_at', '>=', now()->subDays(90)->toDateString())->orderByDesc('observed_at')->limit(100)->get()
            ->map(fn ($r) => ['id' => $r->apn, 'price' => (float) $r->price, 'acres' => (float) $r->acres,
                'status' => $r->status, 'source' => $r->source, 'source_url' => $r->source_url,
                'observed_at' => $r->observed_at, 'sold_date' => $r->sold_date, 'address' => $r->address, 'city' => $r->city, 'latitude' => $r->latitude, 'longitude' => $r->longitude])->all();
        if (!$records) {
            $county = config('counties.'.$fips);
            if (!$county) { return ['records' => [], 'note' => 'County matching is unavailable. Contact support.']; }
            try { $records = $client->countyComps($county['state_name'], $county['name'], $min, $max); }
            catch (\Throwable $error) {
                return ['records' => [], 'note' => 'Comparable records are unavailable within the provider allowance. The valuation is shown separately.'];
            }
        }
        $records = array_values(array_filter($records, fn ($r) => (string) ($r['id'] ?? '') !== $apn));
        foreach ($records as &$record) {
            $record['distance_miles'] = $this->distance($valuation['latitude'] ?? null, $valuation['longitude'] ?? null,
                $record['latitude'] ?? null, $record['longitude'] ?? null);
        }
        unset($record);
        usort($records, fn ($a, $b) => ($a['distance_miles'] ?? INF) <=> ($b['distance_miles'] ?? INF));
        return ['records' => array_slice($records, 0, 25),
            'note' => 'County land records with acreage between half and twice the subject parcel. Distances are shown only when both locations are supplied. These records do not independently verify the provider valuation.'];
    }

    private function distance($a, $b, $c, $d): ?float
    {
        foreach ([$a, $b, $c, $d] as $v) { if (!is_numeric($v)) { return null; } }
        if (abs($a) > 90 || abs($c) > 90 || abs($b) > 180 || abs($d) > 180) { return null; }
        $angle = sin(deg2rad($c - $a) / 2) ** 2 + cos(deg2rad($a)) * cos(deg2rad($c)) * sin(deg2rad($d - $b) / 2) ** 2;
        return round(3958.7613 * 2 * asin(sqrt(min(1, $angle))), 2);
    }
}
