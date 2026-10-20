<?php

namespace App\Services;

use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionSync
{
    public function sync(object $subscription): void
    {
        DB::transaction(function () use ($subscription) {
            $account = BillingAccount::where('customer_id', $subscription->customer)->lockForUpdate()->firstOrFail();
            $price = $subscription->items->data[0]->price ?? null;
            $plan = $subscription->metadata->plan ?? null;
            $version = DB::table('plan_price_versions')->where('plan', $plan)->where('id', $subscription->metadata->price_version ?? 0)->first();
            $catalog = DB::table('stripe_catalog')->where('price_id', $price->id ?? '')->first();
            if ($catalog) {
                $version = DB::table('plan_price_versions')->find($catalog->version_id);
                $plan = $version->plan;
            }
            abort_unless($version && $price && $price->currency === 'usd' && $price->unit_amount === $version->amount
                && $price->recurring->interval === $version->interval && count($subscription->items->data) === 1
                && ($subscription->items->data[0]->quantity ?? 1) === 1
                && (string) ($subscription->metadata->user_id ?? '') === (string) $account->user_id, 403);
            $account->update(['subscription_id' => $subscription->id, 'plan' => $plan,
                'status' => $subscription->status,
                'period_end' => Carbon::createFromTimestamp($subscription->current_period_end),
                'trial_used' => $account->trial_used || (bool) $subscription->trial_start]);
            User::whereKey($account->user_id)->update(['is_subscribed' => $account->hasAccess()]);
        });
    }
}
