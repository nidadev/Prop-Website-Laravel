<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ImportComparables extends Command
{
    protected $signature = 'comparables:import {file : Path to a CSV file}';
    protected $description = 'Validate and import sourced comparable sales/listings atomically';

    public function handle(): int
    {
        $handle = @fopen($this->argument('file'), 'r');
        if (!$handle) { $this->error('Cannot read the CSV file.'); return self::FAILURE; }
        try {
            $headers = array_map(fn ($v) => strtolower(trim($v, "\xEF\xBB\xBF \t\r\n")), fgetcsv($handle) ?: []);
            $required = ['state', 'county_fips', 'apn', 'property_type', 'status', 'price', 'source', 'source_url', 'observed_at'];
            if (array_diff($required, $headers) || count($headers) !== count(array_unique($headers))) {
                $this->error('Use unique column headings: '.implode(', ', $required).', acres, square_feet.'); return self::FAILURE;
            }
            $rows = []; $line = 1;
            while (($values = fgetcsv($handle)) !== false) {
                $line++;
                if ($values === [null]) { continue; }
                if (count($values) !== count($headers)) { $this->error("Row {$line}: column count does not match."); return self::FAILURE; }
                $row = array_intersect_key(array_combine($headers, array_map('trim', $values)), array_flip([...$required, 'acres', 'square_feet']));
                $row['state'] = strtolower($row['state']);
                $row['county_fips'] = str_pad($row['county_fips'], 5, '0', STR_PAD_LEFT);
                foreach (['acres', 'square_feet'] as $key) { $row[$key] = ($row[$key] ?? '') === '' ? null : $row[$key]; }
                $validator = Validator::make($row, [
                    'state' => ['required', Rule::in(array_keys(config('property.states')))],
                    'county_fips' => ['required', 'regex:/^\d{5}$/'], 'apn' => 'required|string|max:100',
                    'property_type' => ['required', Rule::in(['land', 'house'])],
                    'status' => ['required', Rule::in(['sold', 'for_sale'])],
                    'price' => 'required|numeric|gt:0|max:9999999999999',
                    'acres' => 'nullable|numeric|gt:0|max:9999999999',
                    'square_feet' => 'nullable|numeric|gt:0|max:9999999999999',
                    'source' => 'required|string|max:255', 'source_url' => 'required|url:http,https',
                    'observed_at' => 'required|date_format:Y-m-d|before_or_equal:today',
                ]);
                if ($validator->fails() || (int) substr($row['county_fips'], 0, 2) !== (config('property.states')[$row['state']] ?? -1)) {
                    $this->error("Row {$line}: invalid comparable record. ".$validator->errors()->first()); return self::FAILURE;
                }
                $rows[] = $row + ['created_at' => now(), 'updated_at' => now()];
                if (count($rows) > 25000) { $this->error('Import at most 25,000 records per file.'); return self::FAILURE; }
            }
            if (!$rows) { $this->error('No comparable records found.'); return self::FAILURE; }
            DB::transaction(function () use ($rows) {
                foreach (array_chunk($rows, 500) as $chunk) {
                    DB::table('comparable_sales')->upsert($chunk,
                        ['state', 'county_fips', 'apn', 'source', 'status', 'observed_at'],
                        ['property_type', 'price', 'acres', 'square_feet', 'source_url', 'updated_at']);
                }
            });
            $this->info(count($rows).' comparable records imported.'); return self::SUCCESS;
        } finally { fclose($handle); }
    }
}
