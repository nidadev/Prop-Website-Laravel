<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComparableImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_is_idempotent_and_invalid_files_do_not_partially_import(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'comps');
        $header = "state,county_fips,apn,property_type,status,price,source,source_url,observed_at,acres,square_feet\n";
        $record = "ca,06065,00123,land,sold,12000,Client,https://example.com/sale,2024-06-01,2,\n";
        try {
            file_put_contents($path, $header.$record);
            $this->artisan('comparables:import', ['file' => $path])->assertSuccessful();
            $this->artisan('comparables:import', ['file' => $path])->assertSuccessful();
            $this->assertDatabaseCount('comparable_sales', 1);
            $this->assertDatabaseHas('comparable_sales', ['apn' => '00123', 'price' => 12000]);
            file_put_contents($path, $header.str_replace('00123', 'new', $record).str_replace('12000', '-1', $record));
            $this->artisan('comparables:import', ['file' => $path])->assertFailed();
            $this->assertDatabaseCount('comparable_sales', 1);
        } finally { unlink($path); }
    }
}
