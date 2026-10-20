<?php

namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use App\Services\SubscriptionSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SubscriptionLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_plan_changes_cancellation_and_invalid_customer_metadata_control_entitlements(): void
    {
        $user = User::factory()->create();
        BillingAccount::create(['user_id' => $user->id, 'customer_id' => 'cus_lifecycle']);
        $version = DB::table('plan_price_versions')->where('plan', 'bronze')->first();
        $sub = json_decode(json_encode(['id' => 'sub_lifecycle', 'customer' => 'cus_lifecycle', 'status' => 'trialing',
            'current_period_end' => now()->addDays(14)->timestamp, 'trial_start' => now()->timestamp,
            'metadata' => ['user_id' => (string) $user->id, 'plan' => 'bronze', 'price_version' => $version->id],
            'items' => ['data' => [['quantity' => 1, 'price' => ['id' => 'price_bronze', 'currency' => 'usd', 'unit_amount' => $version->amount, 'recurring' => ['interval' => 'month']]]]] ]));
        app(SubscriptionSync::class)->sync($sub);
        $this->assertTrue((bool) $user->fresh()->is_subscribed);
        $gold = DB::table('plan_price_versions')->where('plan', 'gold')->first();
        DB::table('stripe_catalog')->insert(['price_id' => 'price_gold', 'version_id' => $gold->id, 'product_id' => 'prod_gold', 'account_key' => 'test-account', 'created_at' => now(), 'updated_at' => now()]);
        $sub->status = 'active'; $sub->items->data[0]->price->id = 'price_gold';
        $sub->items->data[0]->price->unit_amount = $gold->amount; $sub->items->data[0]->price->recurring->interval = 'year';
        app(SubscriptionSync::class)->sync($sub);
        $this->assertDatabaseHas('billing_accounts', ['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active']);
        $sub->status = 'canceled'; app(SubscriptionSync::class)->sync($sub);
        $this->assertFalse((bool) $user->fresh()->is_subscribed);
        $sub->metadata->user_id = '999999'; $sub->status = 'active';
        try { app(SubscriptionSync::class)->sync($sub); $this->fail('Wrong owner accepted'); }
        catch (\Symfony\Component\HttpKernel\Exception\HttpException $error) { $this->assertSame(403, $error->getStatusCode()); }
        $this->assertFalse((bool) $user->fresh()->is_subscribed);
    }
}

