<?php
namespace Tests\Feature;
use App\Models\CheckoutOrder;
use App\Models\User;
use App\Services\CheckoutFulfillment;
use App\Services\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;
class WalletTest extends TestCase {
    use RefreshDatabase;
    public function test_topup_is_credited_once_even_when_payment_is_replayed(): void {
        $user = User::factory()->create();
        $order = CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => $user->id, 'service' => 'wallet_topup',
            'property_ids' => [], 'amount' => 50, 'session_id' => 'cs_wallet']);
        $session = json_decode(json_encode(['id' => 'cs_wallet', 'payment_status' => 'paid', 'currency' => 'usd',
            'amount_total' => 50, 'client_reference_id' => (string) $user->id, 'metadata' => ['order_id' => $order->id]]));
        app(CheckoutFulfillment::class)->fulfill($session); app(CheckoutFulfillment::class)->fulfill($session);
        $this->assertSame(50, app(Wallet::class)->balance($user->id)); $this->assertDatabaseCount('wallet_entries', 1);
    }
    public function test_small_list_uses_exact_credit_cost_and_cannot_be_paid_twice(): void {
        Queue::fake(); config(['prycd.enabled' => true, 'prycd.key' => 'fake']);
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        app(Wallet::class)->change($user->id, 50, 'test-credit', 'Test credit');
        $id = DB::table('list_uploads')->insertGetId(['user_id' => $user->id, 'record_count' => 1]);
        DB::table('list_upload_rows')->insert(['list_upload_id' => $id, 'apn' => '001', 'state' => 'ca', 'county_fips' => '06065']);
        $this->actingAs($user)->post('/stripe', ['upload_id' => $id])->assertRedirect('/list-upload/'.$id);
        $this->assertSame(47, app(Wallet::class)->balance($user->id));
        $this->post('/stripe', ['upload_id' => $id])->assertStatus(422);
        $this->assertSame(47, app(Wallet::class)->balance($user->id));
        $this->assertDatabaseCount('checkout_orders', 1); Queue::assertPushed(\App\Jobs\PriceApnList::class, 1);
    }
    public function test_disabled_property_data_does_not_take_payment_or_queue_searches(): void {
        config(['property.datatree_enabled' => false]); Queue::fake();
        $user = User::factory()->create(['is_verified' => 1, 'is_subscribed' => 1]);
        $this->actingAs($user)->get('/priceland')->assertStatus(503)->assertSee('temporarily unavailable');
        $this->post('/stripe', ['exp_data_download' => ['123'], 'pdf_check' => 1])->assertSessionHas('error');
        $this->assertDatabaseCount('checkout_orders', 0); Queue::assertNothingPushed();
    }
}
