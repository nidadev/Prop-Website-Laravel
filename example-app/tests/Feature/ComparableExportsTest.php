<?php
namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ComparableExportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_kml_preserves_real_locations_escapes_text_and_enforces_ownership_and_plan(): void
    {
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $rows = [
            ['address' => 'Land <A> & B', 'latitude' => 47.5, 'longitude' => -122.3, 'price' => 40000, 'source_url' => 'https://example.com/?a=1&b=2'],
            ['address' => 'Missing location', 'latitude' => '', 'longitude' => ''],
            ['address' => 'Invalid location', 'latitude' => 95, 'longitude' => 10],
        ];
        $id = DB::table('comp_searches')->insertGetId(['user_id' => $user->id, 'filters' => '{}', 'results' => json_encode($rows), 'created_at' => now(), 'updated_at' => now()]);
        $this->actingAs($user)->get('/land-comps/'.$id.'/kml')->assertForbidden();
        $billing = BillingAccount::create(['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active', 'period_end' => now()->addMonth()]);
        $response = $this->get('/land-comps/'.$id.'/kml')->assertOk()->assertHeader('Content-Type', 'application/vnd.google-earth.kml+xml; charset=UTF-8');
        $xml = simplexml_load_string($response->getContent());
        $this->assertNotFalse($xml);
        $xml->registerXPathNamespace('k', 'http://www.opengis.net/kml/2.2');
        $this->assertCount(1, $xml->xpath('//k:Placemark'));
        $this->assertSame('Land <A> & B', (string) $xml->xpath('//k:Placemark/k:name')[0]);
        $this->assertSame('-122.3,47.5,0', (string) $xml->xpath('//k:coordinates')[0]);
        $this->assertStringNotContainsString('Missing location', $response->getContent());
        $billing->update(['period_end' => now()->subDay()]);
        $this->get('/land-comps/'.$id.'/kml')->assertRedirect('/subscription');
        $other = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1, 'usertype' => 'admin']);
        $this->actingAs($other)->get('/land-comps/'.$id.'/kml')->assertNotFound();
    }

    public function test_research_acreage_filters_apply_to_table_and_export_and_reject_reversed_ranges(): void
    {
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        foreach ([4, 20] as $acres) {
            DB::table('comparable_sales')->insert(['state' => 'ca', 'county_fips' => '06065', 'apn' => 'parcel-'.$acres, 'property_type' => 'land', 'status' => 'sold', 'price' => 40000, 'acres' => $acres, 'source' => 'Client dataset', 'source_url' => 'https://example.com/record', 'observed_at' => now()->toDateString(), 'created_at' => now(), 'updated_at' => now()]);
        }
        $this->actingAs($user)->get('/research?min_acres=3&max_acres=5')->assertOk()->assertSee('parcel-4')->assertDontSee('parcel-20');
        $this->get('/research?min_acres=5&max_acres=3')->assertUnprocessable();
        BillingAccount::create(['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active', 'period_end' => now()->addMonth()]);
        $response = $this->get('/research/download?min_acres=3&max_acres=5')->assertOk();
        $this->assertStringContainsString('parcel-4', $response->streamedContent());
        $this->assertStringNotContainsString('parcel-20', $response->streamedContent());
    }
}
