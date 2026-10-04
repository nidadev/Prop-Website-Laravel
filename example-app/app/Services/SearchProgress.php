<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SearchProgress
{
    public static function key(string $type, int $user, string $state, string $county): string
    {
        return 'search-progress:'.hash('sha256', json_encode([$type, $user, $state, $county]));
    }

    public static function start(string $type, int $user, string $state, string $county): void
    {
        Cache::put(self::key($type, $user, $state, $county), ['status' => 'pending', 'started' => time()], now()->addHour());
    }

    public static function fail(string $type, int $user, string $state, string $county): void
    {
        Cache::put(self::key($type, $user, $state, $county), ['status' => 'failed'], now()->addHour());
    }

    public static function unavailable(string $type, int $user, array $selection): bool
    {
        $progress = Cache::get(self::key($type, $user, $selection['state'], $selection['county_name']));
        return !$progress || $progress['status'] === 'failed' || time() - ($progress['started'] ?? 0) > 900;
    }
}
