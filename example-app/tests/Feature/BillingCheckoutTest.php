<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\BillingAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Stripe\ApiRequestor;
use Stripe\HttpClient\ClientInterface;
use Tests\TestCase;

class BillingCheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_repeated_clicks_reuse_checkout_and_keep_trial_once(): void
    {
        config(['app.stripe_secret' => 'sk_test_fake']);
        $client = new class implements ClientInterface {
            public array $requests = [];
            public function request($method, $absUrl, $headers, $params, $hasFile) {
                $this->requests[] = compact('method', 'absUrl', 'params');
                if (str_ends_with($absUrl, '/customers')) {
                    return [json_encode(['id' => 'cus_test', 'object' => 'customer']), 200, []];
                }
                if (str_ends_with($absUrl, '/products')) { return [json_encode(['id' => 'prod_test', 'object' => 'product']), 200, []]; }
                if (str_ends_with($absUrl, '/prices')) { return [json_encode(['id' => 'price_test', 'object' => 'price']), 200, []]; }
                return [json_encode(['id' => 'cs_test', 'object' => 'checkout.session', 'status' => 'open',
                    'url' => 'https://checkout.stripe.com/c/pay/cs_test', 'expires_at' => time() + 3600]), 200, []];
            }
        };
        ApiRequestor::setHttpClient($client);
        try {
            $user = User::factory()->create(['is_verified' => 1]);
            $this->actingAs($user)->post('/create-subscription', ['plan' => 'bronze'])->assertRedirect('https://checkout.stripe.com/c/pay/cs_test');
            $this->post('/create-subscription', ['plan' => 'bronze'])->assertRedirect('https://checkout.stripe.com/c/pay/cs_test');
            $creates = array_values(array_filter($client->requests, fn ($r) => $r['method'] === 'post' && str_ends_with($r['absUrl'], '/checkout/sessions')));
            $this->assertCount(1, $creates);
            $this->assertSame(14, $creates[0]['params']['subscription_data']['trial_period_days']);
            $this->assertSame('cs_test', BillingAccount::where('user_id', $user->id)->first()->checkout_session_id);
        } finally {
            ApiRequestor::setHttpClient(new \Stripe\HttpClient\CurlClient());
        }
    }
}

