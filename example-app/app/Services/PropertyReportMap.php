<?php
namespace App\Services;

class PropertyReportMap
{
    public function image(array $filters, array $records): ?string
    {
        $points = [];
        $subject = PropertyCoordinates::pair($filters['latitude'] ?? null, $filters['longitude'] ?? null);
        if ($subject) { $points[] = [$subject, 'S', '#d83c50']; }
        foreach ($records as $i => $record) {
            $point = PropertyCoordinates::pair($record['latitude'] ?? null, $record['longitude'] ?? null);
            if ($point) { $points[] = [$point, 'C'.($i + 1), '#6253c5']; }
        }
        if (!$points) { return null; }
        $lats = array_column(array_column($points, 0), 0); $lngs = array_column(array_column($points, 0), 1);
        $minLat = min($lats); $minLng = min($lngs); $latRange = max(.002, max($lats) - $minLat); $lngRange = max(.002, max($lngs) - $minLng);
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="280" viewBox="0 0 600 280"><rect x="1" y="1" width="598" height="278" fill="#f4f2fc" stroke="#ccc7e5"/>';
        $groups = [];
        foreach ($points as [$point, $label, $color]) {
            $key = implode(',', $point);
            if (!isset($groups[$key])) { $groups[$key] = [$point, $label, $color, 0]; }
            else { $groups[$key][3]++; }
        }
        foreach ($groups as [$point, $label, $color, $extra]) {
            if ($extra) { $label .= ' +'.$extra; }
            $x = round(35 + ($point[1] - $minLng) / $lngRange * 520, 2);
            $y = round(235 - ($point[0] - $minLat) / $latRange * 200, 2);
            $svg .= '<circle cx="'.$x.'" cy="'.$y.'" r="5" fill="'.$color.'"/><text x="'.($x + 7).'" y="'.($y - 5).'" font-family="sans-serif" font-size="10">'.$label.'</text>';
        }
        $svg .= '<text x="20" y="268" font-family="sans-serif" font-size="10">Relative locations. North is up. S = subject; C = table row; + = coincident records.</text></svg>';
        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
