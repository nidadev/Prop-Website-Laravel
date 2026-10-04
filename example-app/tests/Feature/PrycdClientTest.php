<?php

namespace Tests\Feature;

use App\Services\PrycdClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PrycdClientTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;
    public function test_documented_pricing_request_preserves_apn_and_returns_provider_provenance(): void
    {
        config(['prycd.enabled' => true, 'prycd.key' => 'test-key']);
        Http::preventStrayRequests();
        Http::fake(['prycd-pricing.p.rapidapi.com/*' => Http::response(['status' => 200, 'apn' => '00123',
            'pricing' => ['price' => 200000, 'price_per_acre' => 5000, 'pricing_source' => 'Geo', 'confidence' => '87.8%']])]);
        $result = app(PrycdClient::class)->priceLand('00123', '06065');
        $this->assertSame(200000.0, $result['market_value']);
        $this->assertSame('PRYCD', $result['source']);
        Http::assertSent(fn ($request) => $request->url() === 'https://prycd-pricing.p.rapidapi.com/priceProperty'
            && $request['apn'] === '00123' && $request['county_fips'] === '06065');
    }

    public function test_unconfigured_api_does_not_make_requests(): void
    {
        config(['prycd.enabled' => false]); Http::fake();
        try { app(PrycdClient::class)->priceLand('00123', '06065'); $this->fail('Expected unavailable access.'); }
        catch (\RuntimeException $e) { $this->assertStringContainsString('not been configured', $e->getMessage()); }
        Http::assertNothingSent();
    }

    public function test_other_apn_price_is_rejected(): void
    {
        config(['prycd.enabled' => true, 'prycd.key' => 'test-key']);
        Http::fake(['*' => Http::response(['status' => 200, 'apn' => 'other', 'pricing' => ['price' => 100]])]);
        $this->expectException(\RuntimeException::class);
        app(PrycdClient::class)->priceLand('00123', '06065');
    }

    public function test_county_comps_normalize_prices_and_retain_source_links_without_inventing_values(): void
    {
        config(['prycd.enabled' => true, 'prycd.key' => 'test-key']);
        Http::fake(['*' => Http::response(['status' => 200, 'data' => [['county' => 'King County', 'comps' => [[
            'acreage' => '3.5-12', 'comps' => [
                ['id' => 'sample', 'price' => '$17,000.00', 'acreage' => '5.00', 'status' => 'Sold', 'source' => 'Zillow', 'url' => 'https://example.com/comp'],
                ['price' => null, 'acreage' => '1.00'],
            ],
        ]]]]])]);
        $comps = app(PrycdClient::class)->countyComps('Washington', 'King County', 3.5, 12);
        $this->assertCount(1, $comps);
        $this->assertSame(17000.0, $comps[0]['price']);
        $this->assertSame('https://example.com/comp', $comps[0]['source_url']);
    }
    public function test_repeated_pricing_reuses_the_verified_result_without_consuming_another_request(): void
    {
        config(['prycd.enabled'=>true,'prycd.key'=>'test-key']);
        Http::fake(['*'=>Http::response(['status'=>200,'apn'=>'00123','pricing'=>['price'=>100]])]);
        $first=app(PrycdClient::class)->priceLand('00123','06065');
        $this->travel(1)->hours();
        $second=app(PrycdClient::class)->priceLand('00123','06065');
        $this->assertSame($first,$second);
        Http::assertSentCount(1);
        $this->assertDatabaseHas('provider_usage',['service'=>'pricing','requests'=>1]);
    }
    public function test_an_exhausted_allowance_does_not_send_a_provider_request(): void
    {
        config(['prycd.enabled'=>true,'prycd.key'=>'test-key','prycd.pricing_request_limit'=>0]);
        Http::fake();
        try { app(PrycdClient::class)->priceLand('00123','06065'); $this->fail('Expected exhausted allowance.'); }
        catch (\RuntimeException $e) { $this->assertStringContainsString('allowance',$e->getMessage()); }
        Http::assertNothingSent();
    }
}
