<?php

namespace App\Console\Commands;

use App\Models\BillingAccount;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class AuditLegacySubscriptions extends Command
{
    protected $signature = 'billing:audit-legacy {--output= : Private output file outside public_html}';
    protected $description = 'Read-only reconciliation of legacy subscribers against the configured Stripe account';

    public function handle(): int
    {
        if (!config('app.stripe_secret')) { $this->error('Stripe is not configured.'); return self::FAILURE; }
        $stripe = new StripeClient(config('app.stripe_secret'));
        $rows = [];
        foreach (User::where('is_subscribed', 1)->whereNotIn('id', BillingAccount::select('user_id'))->cursor() as $user) {
            $legacy = DB::table('subscription_details')->where('user_id', $user->id)->latest()->first();
            $row = ['user_id' => $user->id, 'result' => 'manual_review', 'reason' => 'No provider subscription identifier'];
            if ($legacy && $legacy->stripe_subscription_id) {
                try {
                    $subscription = $stripe->subscriptions->retrieve($legacy->stripe_subscription_id);
                    if ($subscription->customer !== $legacy->stripe_customer_id) {
                        $row['reason'] = 'Customer identity mismatch';
                    } else {
                        $row['provider_status'] = $subscription->status;
                        $row['period_end'] = $subscription->current_period_end ?? null;
                        $row['reason'] = 'Provider record found; confirm plan mapping and agreed legacy price before migration';
                    }
                } catch (\Stripe\Exception\InvalidRequestException $error) {
                    $row['reason'] = 'Subscription not found in the configured Stripe account/mode';
                } catch (\Throwable $error) {
                    $row['reason'] = 'Provider check unavailable; retry after confirming account access';
                }
            }
            $rows[] = $row;
        }
        if ($path = $this->option('output')) {
            $directory = realpath(dirname($path));
            if (!$directory || str_starts_with($directory.DIRECTORY_SEPARATOR, realpath(public_path()).DIRECTORY_SEPARATOR)
                || str_contains(str_replace('\\', '/', $directory).'/', '/public_html/')) {
                $this->error('Choose an existing private directory outside the website root.'); return self::FAILURE;
            }
            file_put_contents($path, json_encode(['checked_at' => now()->toIso8601String(),
                'mode' => str_starts_with(config('app.stripe_secret'), 'sk_test_') ? 'test' : 'live', 'users' => $rows], JSON_PRETTY_PRINT));
            chmod($path, 0600);
        }
        $this->info(count($rows).' legacy accounts reviewed. No provider or customer records were changed.');
        return self::SUCCESS;
    }
}
