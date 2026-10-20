<?php

namespace Tests\Feature;

use App\Jobs\PriceApnList;
use App\Models\BillingAccount;
use App\Models\CheckoutOrder;
use App\Models\User;
use App\Services\ComparableRecords;
use App\Services\PrycdClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;

class RemainingWorkTest extends TestCase
{
    use RefreshDatabase;

    private function comparable(array $changes = []): void
    {
        DB::table('comparable_sales')->insert(array_merge(['state' => 'ca', 'county_fips' => '06065', 'apn' => 'comp-1',
            'property_type' => 'land', 'status' => 'sold', 'price' => 40000, 'acres' => 4,
            'source' => 'Client dataset', 'source_url' => 'https://example.com/record', 'observed_at' => now()->toDateString(),
            'latitude' => 33.9, 'longitude' => -117.4, 'created_at' => now(), 'updated_at' => now()], $changes));
    }

    public function test_matching_uses_recent_sourced_records_excludes_subject_and_computes_only_known_distances(): void
    {
        Http::fake();
        $this->comparable();
        $this->comparable(['apn' => 'subject']);
        $this->comparable(['apn' => 'stale', 'observed_at' => now()->subDays(100)->toDateString()]);
        $this->comparable(['apn' => 'wrong-size', 'acres' => 90]);
        $result = app(ComparableRecords::class)->forParcel('subject', '06065', ['acres' => 4, 'latitude' => 33.9, 'longitude' => -117.4], app(PrycdClient::class));
        $this->assertCount(1, $result['records']);
        $this->assertSame(0.0, $result['records'][0]['distance_miles']);
        $this->assertSame('https://example.com/record', $result['records'][0]['source_url']);
        Http::assertNothingSent();
        $result = app(ComparableRecords::class)->forParcel('subject', '06065', ['acres' => 4], app(PrycdClient::class));
        $this->assertNull($result['records'][0]['distance_miles']);
    }

    public function test_research_filters_and_exports_are_gated_and_empty_results_are_truthful(): void
    {
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->comparable();
        $this->comparable(['apn' => 'out-of-county', 'county_fips' => '06037', 'price' => 90000]);
        $this->actingAs($user)->get('/research?state=ca&county_fips=06065&min_price=30000&max_price=50000')
            ->assertOk()->assertSee('comp-1')->assertDontSee('out-of-county')->assertSee('1 records');
        $this->get('/research?state=wa&county_fips=06065')->assertUnprocessable();
        $this->get('/research?min_price=100&max_price=1')->assertUnprocessable();
        $this->get('/research/download')->assertForbidden();
        BillingAccount::create(['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active', 'period_end' => now()->addMonth()]);
        $response = $this->get('/research/download?county_fips=06065')->assertDownload('propelyze-research.csv');
        $this->assertStringContainsString('comp-1', $response->streamedContent());
        $this->assertStringNotContainsString('out-of-county', $response->streamedContent());
        $this->get('/research?county_fips=06001')->assertSee('No records match these filters');
    }

    public function test_list_processing_continues_in_batches_and_comparable_csv_is_private(): void
    {
        Queue::fake(); Mail::fake(); Http::preventStrayRequests();
        config(['prycd.enabled' => true, 'prycd.key' => 'fake']);
        $this->comparable();
        Http::fake(['prycd-pricing.p.rapidapi.com/*' => fn ($r) => Http::response(['status' => 200, 'apn' => $r['apn'], 'pricing' => ['price' => 40000, 'meta' => ['acreage' => 4]]])]);
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $upload = DB::table('list_uploads')->insertGetId(['user_id' => $owner->id, 'record_count' => 6, 'status' => 'queued']);
        foreach (range(1, 6) as $n) { DB::table('list_upload_rows')->insert(['list_upload_id' => $upload, 'state' => 'ca', 'county_fips' => '06065', 'apn' => 'subject-'.$n]); }
        CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => $owner->id, 'service' => 'list_upload', 'list_upload_id' => $upload, 'property_ids' => [], 'amount' => 18, 'status' => 'paid']);
        $job = new PriceApnList($upload); $job->handle(app(PrycdClient::class));
        $this->assertSame(5, DB::table('list_upload_rows')->where('status', 'completed')->count());
        Queue::assertPushed(PriceApnList::class, 1); Mail::assertNothingSent();
        $job->handle(app(PrycdClient::class)); $job->handle(app(PrycdClient::class));
        Http::assertSentCount(6); Mail::assertSent(\App\Mail\ListPricingCompleted::class, 1);
        $this->assertDatabaseHas('list_uploads', ['id' => $upload, 'status' => 'completed']);
        $response = $this->actingAs($owner)->get('/list-upload/'.$upload.'/comparables')->assertOk();
        $this->assertStringContainsString('Client dataset', $response->streamedContent());
        $this->get('/list-upload/'.$upload)->assertOk()->assertSee('Comparable records (1)');
        $this->actingAs(User::factory()->create())->get('/list-upload/'.$upload.'/comparables')->assertNotFound();
    }

    public function test_saved_provider_records_are_private_and_do_not_fabricate_apns(): void
    {
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $other = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        DB::table('comp_searches')->insert(['user_id' => $owner->id,
            'filters' => json_encode(['state' => 'Washington', 'county' => 'King', 'min_acres' => 1, 'max_acres' => 5]),
            'results' => json_encode([['id' => 'listing-123', 'price' => 42000, 'acres' => 3, 'status' => 'Sold', 'source' => 'Redfin', 'source_url' => 'https://example.com/listing']]),
            'created_at' => now(), 'updated_at' => now()]);
        $this->actingAs($owner)->get('/research?state=wa&county_fips=53033&status=sold')
            ->assertOk()->assertSee('listing-123')->assertSee('42,000.00');
        $this->get('/research')->assertOk();
        $this->assertDatabaseCount('provider_research_records', 1);
        $this->assertDatabaseHas('provider_research_records', ['apn' => null, 'listing_id' => 'listing-123']);
        $this->actingAs($other)->get('/research')->assertOk()->assertDontSee('listing-123');
    }

    public function test_admin_settings_are_rendered_escaped_and_new_embeds_are_restricted(): void
    {
        $this->actingAs(User::factory()->create(['usertype' => 'admin']))
            ->post('/admin/settings', ['contact_email' => 'support@example.com', 'contact_address' => '<script>bad</script>',
                'contact_phone' => '123456', 'copyright' => 'Client copyright', 'youtube_embed_url' => 'https://www.youtube-nocookie.com/embed/abcdefghijk'])
            ->assertRedirect();
        $this->get('/home')->assertOk()->assertSee('support@example.com')->assertSee('Client copyright')
            ->assertSee('&lt;script&gt;bad&lt;/script&gt;', false)->assertSee('www.youtube-nocookie.com/embed/abcdefghijk');
        $this->post('/admin/settings', ['coverage_embed_url' => 'https://example.com/views/fake'])->assertUnprocessable();
    }
}
