<?php

namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use App\Services\PricingCatalog;
use App\Services\SubscriptionSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PricingCatalogTest extends TestCase
{
    use RefreshDatabase;
    public function test_price_changes_apply_to_new_checkouts_and_preserve_old_subscriptions(): void
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $old = DB::table('plan_price_versions')->where('plan', 'bronze')->first();
        $account = BillingAccount::create(['user_id' => $admin->id, 'customer_id' => 'cus_test']);
        $this->actingAs($admin)->post('/admin/pricing', [
            'plan_bronze' => '29.99', 'plan_bronze_plus' => '49.99', 'plan_gold' => '499.00',
            'service_comp_report' => '2.00', 'service_owner_export' => '0.08', 'service_list_upload' => '0.03', 'service_skip_trace' => '0.09',
        ])->assertRedirect();
        $this->assertSame(2999, app(PricingCatalog::class)->plans()['bronze']['amount']);
        $subscription = (object) ['id' => 'sub_existing', 'customer' => 'cus_test',
            'metadata' => (object) ['plan' => 'bronze', 'price_version' => $old->id, 'user_id' => $admin->id],
            'items' => (object) ['data' => [(object) ['quantity' => 1, 'price' => (object) ['currency' => 'usd', 'unit_amount' => 2499, 'recurring' => (object) ['interval' => 'month']]]]],
            'status' => 'active', 'current_period_end' => now()->addMonth()->timestamp, 'trial_start' => null];
        app(SubscriptionSync::class)->sync($subscription);
        $this->assertTrue($account->fresh()->hasAccess());
        $this->assertSame('bronze', $account->fresh()->plan);
        $subscription->items->data[0]->price->unit_amount = 1;
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        app(SubscriptionSync::class)->sync($subscription);
    }
}
