<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ResearchRecords
{
    public function queryForUser(int $userId)
    {
        foreach (DB::table('comp_searches')->where('user_id', $userId)->whereNull('research_indexed_at')->lazyById(20) as $search) {
            $this->index($search);
        }
        $columns = ['id', 'state', 'county_fips', 'apn', 'property_type', 'status', 'price', 'acres', 'square_feet', 'source', 'source_url', 'observed_at'];
        $imported = DB::table('comparable_sales')->select($columns)->selectRaw('NULL as listing_id');
        $provider = DB::table('provider_research_records')->where('user_id', $userId)->select($columns)->addSelect('listing_id')
            ->whereNotExists(function ($q) {
                $q->selectRaw('1')->from('provider_research_records as newer')
                    ->whereColumn('newer.user_id', 'provider_research_records.user_id')
                    ->whereColumn('newer.source_key', 'provider_research_records.source_key')
                    ->whereColumn('newer.id', '>', 'provider_research_records.id');
            });
        return DB::query()->fromSub($imported->unionAll($provider), 'research_records');
    }

    private function index(object $search): void
    {
        DB::transaction(function () use ($search) {
            $locked = DB::table('comp_searches')->where('id', $search->id)->lockForUpdate()->first();
            if ($locked->research_indexed_at) { return; }
            $filters = json_decode($search->filters, true);
            $county = null;
            foreach (config('counties') as $fips => $location) {
                if (in_array(strtolower(trim($filters['state'])), [$location['state'], strtolower($location['state_name'])], true)
                    && strtolower(trim($filters['county'])) === strtolower($location['name'])) {
                    $county = $location + ['fips' => (string) $fips]; break;
                }
            }
            $rows = [];
            if ($county) {
                foreach (json_decode($search->results, true) as $record) {
                    $url = $record['source_url'] ?? '';
                    if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
                        || !is_numeric($record['price'] ?? null) || $record['price'] <= 0 || $record['price'] > 9999999999999) { continue; }
                    $status = strtolower(str_replace([' ', '-'], '_', $record['status'] ?? 'unknown'));
                    $status = match ($status) { 'sold' => 'sold', 'active', 'for_sale' => 'for_sale', default => 'unknown' };
                    $key = hash('sha256', $url.'|'.($record['id'] ?? ''));
                    $rows[$key] = ['comp_search_id' => $search->id, 'user_id' => $search->user_id, 'source_key' => $key,
                        'state' => $county['state'], 'county_fips' => $county['fips'], 'apn' => isset($record['apn']) ? mb_substr((string) $record['apn'], 0, 100) : null,
                        'listing_id' => isset($record['id']) ? mb_substr((string) $record['id'], 0, 255) : null,
                        'property_type' => 'land', 'status' => $status, 'price' => $record['price'],
                        'acres' => is_numeric($record['acres'] ?? null) && $record['acres'] > 0 && $record['acres'] <= 9999999999 ? $record['acres'] : null,
                        'square_feet' => null, 'source' => mb_substr(($record['source'] ?? '') ?: 'PRYCD', 0, 255), 'source_url' => $url,
                        // Observation is when Propelyze saved this response, not an invented sale date.
                        'observed_at' => substr($search->created_at ?: now()->toDateString(), 0, 10), 'created_at' => now(), 'updated_at' => now()];
                }
                foreach (array_chunk(array_values($rows), 500) as $chunk) { DB::table('provider_research_records')->insert($chunk); }
            }
            DB::table('comp_searches')->where('id', $search->id)->update(['research_indexed_at' => now()]);
        });
    }
}
