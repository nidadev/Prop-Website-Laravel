<?php

namespace App\Services;

class PropertyCoordinates
{
    public static function pair($latitude, $longitude): ?array
    {
        if (!is_numeric($latitude) || !is_numeric($longitude)) { return null; }
        $lat = (float) $latitude; $lng = (float) $longitude;
        if (!is_finite($lat) || !is_finite($lng) || abs($lat) > 90 || abs($lng) > 180
            || ($lat === 0.0 && $lng === 0.0)) { return null; }
        return [$lat, $lng];
    }
}
