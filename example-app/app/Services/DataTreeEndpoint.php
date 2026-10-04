<?php
namespace App\Services;

final class DataTreeEndpoint
{
    public static function url(string $path): string
    {
        return rtrim(config('property.datatree_url'), '/').'/'.ltrim($path, '/').'?Ver=1.0';
    }
}
