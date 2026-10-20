<?php

namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use App\Services\ReportAllowance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportAllowanceTest extends TestCase
{
    use RefreshDatabase;
    public function test_gold_has_twenty_reports_per_month_and_repeat_downloads_do_not_use_another_credit(): void
    {
        $user = User::factory()->create();
        BillingAccount::create(['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active', 'period_end' => now()->addYear()]);
        $service = app(ReportAllowance::class);
        for ($i = 1; $i <= 20; $i++) { $this->assertNotNull($service->claim($user->id, [(string) $i])); }
        $this->assertNotNull($service->claim($user->id, ['1']));
        $this->assertNull($service->claim($user->id, ['21']));
        $this->assertDatabaseCount('checkout_orders', 20);
        $this->travel(1)->months();
        $this->assertNotNull($service->claim($user->id, ['21']));
    }
    public function test_bronze_and_expired_accounts_do_not_receive_gold_credits(): void
    {
        $user = User::factory()->create();
        $account = BillingAccount::create(['user_id' => $user->id, 'plan' => 'bronze', 'status' => 'active', 'period_end' => now()->addMonth()]);
        $this->assertNull(app(ReportAllowance::class)->claim($user->id, ['1']));
        $account->update(['plan' => 'gold', 'period_end' => now()->subMinute()]);
        $this->assertNull(app(ReportAllowance::class)->claim($user->id, ['1']));
    }

    public function test_unused_credits_carry_over_and_unvisited_months_do_not_receive_grants(): void
    {
        $user = User::factory()->create();
        BillingAccount::create(['user_id' => $user->id, 'plan' => 'gold', 'status' => 'active', 'period_end' => now()->addYear()]);
        $service = app(ReportAllowance::class);
        $service->visit($user->id); $service->visit($user->id);
        $this->assertDatabaseCount('report_credit_grants', 1);
        $this->travel(2)->months();
        for ($i = 1; $i <= 40; $i++) { $this->assertNotNull($service->claim($user->id, [(string) $i])); }
        $this->assertNull($service->claim($user->id, ['41']));
        $this->assertDatabaseCount('report_credit_grants', 2);
    }
}
