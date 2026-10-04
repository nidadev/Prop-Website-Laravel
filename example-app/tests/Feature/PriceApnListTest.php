<?php

namespace Tests\Feature;

use App\Jobs\PriceApnList;
use App\Models\CheckoutOrder;
use App\Models\User;
use App\Services\PrycdClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class PriceApnListTest extends TestCase
{
    use RefreshDatabase;

    public function test_paid_list_prices_once_marks_failures_and_exports_only_to_its_owner(): void
    {
        \Illuminate\Support\Facades\Mail::fake();
        config(['prycd.enabled' => true, 'prycd.key' => 'test-key']);
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $id = DB::table('list_uploads')->insertGetId(['user_id' => $owner->id, 'record_count' => 2, 'status' => 'queued', 'created_at' => now(), 'updated_at' => now()]);
        foreach (['00123', 'missing'] as $apn) { DB::table('list_upload_rows')->insert(['list_upload_id' => $id, 'state' => 'ca', 'county_fips' => '06065', 'apn' => $apn]); }
        $ids = DB::table('list_upload_rows')->where('list_upload_id', $id)->pluck('id')->map(fn ($v) => (string) $v)->all();
        CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => $owner->id, 'service' => 'list_upload', 'list_upload_id' => $id, 'property_ids' => $ids, 'amount' => 6, 'status' => 'paid']);
        Http::fakeSequence()->push(['status' => 200, 'apn' => '00123', 'pricing' => ['price' => 15000]])->push(['status' => 404], 404);
        $job = new PriceApnList($id);
        $job->handle(app(PrycdClient::class)); $job->handle(app(PrycdClient::class));
        Http::assertSentCount(2);
        $this->assertDatabaseHas('list_upload_rows', ['apn' => '00123', 'status' => 'completed']);
        $this->assertDatabaseHas('list_upload_rows', ['apn' => 'missing', 'status' => 'needs_review']);
        $this->assertDatabaseHas('list_uploads', ['id' => $id, 'status' => 'completed_with_issues']);
        $this->assertSame(3, app(\App\Services\Wallet::class)->balance($owner->id));
        $job->failed(new \RuntimeException('worker interrupted'));
        $this->assertSame(3, app(\App\Services\Wallet::class)->balance($owner->id));
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\ListPricingCompleted::class);
        $this->actingAs($owner)->get('/list-upload/'.$id.'/download')->assertDownload('propelyze-list-'.$id.'.csv');
        $this->actingAs(User::factory()->create())->get('/list-upload/'.$id.'/download')->assertNotFound();
    }

    public function test_provider_must_be_connected_before_any_list_payment_is_requested(): void
    {
        config(['prycd.enabled' => false]);
        $owner = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $id = DB::table('list_uploads')->insertGetId(['user_id' => $owner->id, 'record_count' => 1]);
        $this->actingAs($owner)->from('/list-upload/'.$id)->post('/stripe', ['upload_id' => $id])
            ->assertRedirect('/list-upload/'.$id)->assertSessionHas('error');
        $this->assertDatabaseCount('checkout_orders', 0);
    }
}
