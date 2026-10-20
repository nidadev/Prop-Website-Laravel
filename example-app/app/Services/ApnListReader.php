<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ApnListReader
{
    public function read(string $path, string $extension): array
    {
        $reader = match (strtolower($extension)) {
            'csv' => IOFactory::createReader('Csv'), 'xlsx' => IOFactory::createReader('Xlsx'),
            default => throw ValidationException::withMessages(['file' => 'Use an Excel XLSX or CSV file.']),
        };
        $reader->setReadDataOnly(true);
        $rows = $reader->load($path)->getActiveSheet()->toArray(null, true, true, false);
        $headers = array_map(fn ($v) => strtolower(trim((string) $v)), array_shift($rows) ?? []);
        if (count(array_unique($headers)) !== count($headers)) {
            throw ValidationException::withMessages(['file' => 'Each column must have a unique heading.']);
        }
        foreach (['state', 'county_fips', 'apn'] as $column) {
            if (!in_array($column, $headers, true)) { throw ValidationException::withMessages(['file' => 'Required columns: state, county_fips, apn.']); }
        }
        $records = []; $errors = [];
        foreach ($rows as $index => $row) {
            if (!array_filter($row, fn ($v) => $v !== null && $v !== '')) { continue; }
            $values = array_combine($headers, array_slice(array_pad($row, count($headers), null), 0, count($headers)));
            $state = strtolower(trim((string) $values['state']));
            $county = str_pad(trim((string) $values['county_fips']), 5, '0', STR_PAD_LEFT);
            $apn = trim((string) $values['apn']);
            $states = config('property.states');
            if (!isset($states[$state]) || !preg_match('/^\d{5}$/', $county)
                || (int) substr($county, 0, 2) !== $states[$state] || $apn === '' || strlen($apn) > 100) {
                $errors[] = 'Row '.($index + 2).': check state, county FIPS and APN.'; continue;
            }
            $records[$state.'|'.$county.'|'.$apn] = ['state' => $state, 'county_fips' => $county, 'apn' => $apn];
            if (count($records) > 25000) { throw ValidationException::withMessages(['file' => 'Upload at most 25,000 records.']); }
        }
        if ($errors) { throw ValidationException::withMessages(['file' => implode(' ', array_slice($errors, 0, 10))]); }
        if (!$records) { throw ValidationException::withMessages(['file' => 'No valid APN records were found.']); }
        return array_values($records);
    }
}
