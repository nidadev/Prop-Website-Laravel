<?php
namespace App\Services;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
class StripeCatalog {
    public function price(string $key, array $plan, StripeClient $stripe): object {
        $accountKey = hash('sha256', config('app.stripe_secret'));
        return Cache::lock('stripe-price-'.$accountKey.'-'.$plan['version_id'], 60)->block(5, function () use ($key, $plan, $stripe, $accountKey) {
            $existing = DB::table('stripe_catalog')->where('version_id', $plan['version_id'])->where('account_key', $accountKey)->first();
            if ($existing) { return $existing; }
            $idempotency = 'propelyze-catalog-'.$plan['version_id'].'-'.$accountKey;
            $product = $stripe->products->create(['name' => 'Propelyze '.$plan['name'],
                'metadata' => ['plan' => $key]], ['idempotency_key' => $idempotency.'-product']);
            $price = $stripe->prices->create(['product' => $product->id, 'currency' => 'usd', 'unit_amount' => $plan['amount'],
                'recurring' => ['interval' => $plan['interval']], 'metadata' => ['plan' => $key, 'price_version' => (string) $plan['version_id']]],
                ['idempotency_key' => $idempotency.'-price']);
            DB::table('stripe_catalog')->insert(['version_id' => $plan['version_id'], 'account_key' => $accountKey,
                'product_id' => $product->id, 'price_id' => $price->id, 'created_at' => now(), 'updated_at' => now()]);
            return DB::table('stripe_catalog')->where('price_id', $price->id)->first();
        });
    }
    public function portalConfiguration(StripeClient $stripe): string {
        $products = []; $versions = [];
        foreach (app(PricingCatalog::class)->plans() as $key => $plan) {
            $price = $this->price($key, $plan, $stripe);
            $products[] = ['product' => $price->product_id, 'prices' => [$price->price_id]];
            $versions[] = $plan['version_id'];
        }
        $reference = hash('sha256', config('app.stripe_secret').json_encode($versions));
        return Cache::rememberForever('stripe-portal-'.$reference, function () use ($stripe, $products, $reference) {
            return $stripe->billingPortal->configurations->create([
                'business_profile' => ['headline' => 'Manage your Propelyze subscription'],
                'default_return_url' => url('/billing/sync'),
                'features' => ['invoice_history' => ['enabled' => true], 'payment_method_update' => ['enabled' => true],
                    'subscription_cancel' => ['enabled' => true, 'mode' => 'at_period_end'],
                    'subscription_update' => ['enabled' => true, 'default_allowed_updates' => ['price'],
                        'products' => $products, 'proration_behavior' => 'create_prorations']],
            ], ['idempotency_key' => 'propelyze-portal-'.$reference])->id;
        });
    }
}
