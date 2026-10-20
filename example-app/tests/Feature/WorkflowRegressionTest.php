<?php
namespace Tests\Feature;

use App\Models\User;
use App\Services\PropertyCoordinates;
use App\Services\ResearchRecords;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class WorkflowRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_map_rejects_missing_zero_and_out_of_range_locations(): void
    {
        foreach ([[null, null], ['', ''], [' ', '-122'], [0, 0], [91, -122], [47, -181], ['NaN', 1]] as $pair) {
            $this->assertNull(PropertyCoordinates::pair(...$pair));
        }
        $this->assertSame([47.556, -122.3941], PropertyCoordinates::pair('47.5560', '-122.3941'));
    }

    public function test_repeat_searches_show_only_latest_source_record_in_research(): void
    {
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        foreach ([10000, 12000] as $price) {
            DB::table('comp_searches')->insert(['user_id' => $user->id,
                'filters' => json_encode(['state' => 'Washington', 'county' => 'King', 'min_acres' => 1, 'max_acres' => 5]),
                'results' => json_encode([['id' => 'listing-1', 'price' => $price, 'acres' => 2, 'status' => 'Sold', 'source_url' => 'https://www.redfin.com/example', 'source' => 'Redfin']]),
                'created_at' => now(), 'updated_at' => now()]);
        }
        $q = app(ResearchRecords::class)->queryForUser($user->id);
        $this->assertSame(1, $q->count());
        $this->assertEquals(12000, $q->first()->price);
        $other = User::factory()->create();
        $this->assertSame(0, app(ResearchRecords::class)->queryForUser($other->id)->count());
    }

    public function test_resubmitting_older_valuation_adds_comps_without_repricing(): void
    {
        config(['prycd.enabled' => true, 'prycd.key' => 'fake']);
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $id = DB::table('land_valuations')->insertGetId(['user_id' => $user->id, 'apn' => '00123', 'county_fips' => '06017',
            'result' => json_encode(['market_value' => 10000, 'acres' => 2, 'source' => 'PRYCD']), 'created_at' => now(), 'updated_at' => now()]);
        Http::preventStrayRequests();
        Http::fake(['prycd-comps.p.rapidapi.com/*' => Http::response(['status' => 200, 'data' => [['comps' => [['comps' => [
            ['id' => 'subject-listing', 'apn' => '00123', 'price' => 10000, 'acreage' => 2],
            ['id' => 'other', 'apn' => '00456', 'price' => 11000, 'acreage' => 2],
        ]]]]]])]);
        $this->actingAs($user)->post('/land-valuation', ['apn' => '00123', 'county_fips' => '06017'])->assertRedirect('/land-valuation/'.$id);
        $this->post('/land-valuation', ['apn' => '00123', 'county_fips' => '06017'])->assertRedirect('/land-valuation/'.$id);
        Http::assertSentCount(1);
        $result = json_decode(DB::table('land_valuations')->find($id)->result, true);
        $this->assertEquals(10000, $result['market_value']);
        $this->assertCount(1, $result['comparables']['records']);
        $this->assertSame('00456', $result['comparables']['records'][0]['apn']);
    }
}
