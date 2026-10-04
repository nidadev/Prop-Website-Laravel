<?php

namespace App\Services;

use App\Models\BillingAccount;
use App\Models\CheckoutOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportAllowance
{
    public function visit(int $userId): void
    {
        DB::transaction(function () use ($userId) {
            $account = BillingAccount::where('user_id', $userId)->lockForUpdate()->first();
            if ($account && $account->hasAccess() && $account->plan === 'gold') {
                DB::table('report_credit_grants')->insertOrIgnore([
                    'user_id' => $userId, 'month' => now()->format('Y-m'),
                    'credits' => config('pricing.plans.gold.reports'), 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        });
    }

    public function claim(int $userId, array $propertyIds, string $service = 'comp_report'): ?CheckoutOrder
    {
        $this->visit($userId);
        return DB::transaction(function () use ($userId, $propertyIds, $service) {
            $account = BillingAccount::where('user_id', $userId)->lockForUpdate()->first();
            if (!$account || !$account->hasAccess() || $account->plan !== 'gold') { return null; }
            $existing = CheckoutOrder::where('user_id', $userId)->where('service', $service)
                ->where('status', 'paid')->get()->first(fn ($order) => $order->property_ids === $propertyIds);
            if ($existing) { return $existing; }
            $used = CheckoutOrder::where('user_id', $userId)->whereIn('service', ['comp_report', 'land_report'])
                ->where('status', 'paid')->where('amount', 0)->count();
            $granted = DB::table('report_credit_grants')->where('user_id', $userId)->sum('credits');
            if ($used >= $granted) { return null; }
            return CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => $userId,
                'service' => $service, 'property_ids' => $propertyIds, 'amount' => 0, 'status' => 'paid']);
        });
    }
}
