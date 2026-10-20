<?php

namespace Tests\Feature;

use App\Models\CheckoutOrder;
use App\Models\User;
use App\Services\CheckoutFulfillment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class CheckoutSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function order(): CheckoutOrder
    {
        return CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => User::factory()->create()->id,
            'service' => 'comp_report', 'property_ids' => ['123'], 'amount' => 200, 'session_id' => 'cs_test_verified']);
    }
    private function checkoutSession(CheckoutOrder $order): object
    {
        return (object) ['id' => $order->session_id, 'payment_status' => 'paid', 'currency' => 'usd',
            'amount_total' => 200, 'client_reference_id' => (string) $order->user_id,
            'metadata' => (object) ['order_id' => $order->id], 'customer_details' => (object) ['name' => 'Test', 'email' => 'test@example.test']];
    }
    public function test_repeated_payment_events_grant_access_and_record_payment_once(): void
    {
        $order = $this->order(); $session = $this->checkoutSession($order);
        $service = app(CheckoutFulfillment::class);
        $service->fulfill($session); $service->fulfill($session);
        $this->assertDatabaseCount('payments', 1);
        $this->assertSame('paid', $order->fresh()->status);
    }
    public function test_unpaid_or_underpaid_sessions_cannot_grant_access(): void
    {
        foreach (['unpaid', 'underpaid', 'wrong_owner'] as $case) {
            $order = $this->order(); $order->update(['session_id' => 'cs_'.$case]); $session = $this->checkoutSession($order->fresh());
            if ($case === 'unpaid') { $session->payment_status = 'unpaid'; }
            if ($case === 'underpaid') { $session->amount_total = 1; }
            if ($case === 'wrong_owner') { $session->client_reference_id = '999999'; }
            try { app(CheckoutFulfillment::class)->fulfill($session); $this->fail('Invalid session was accepted'); }
            catch (HttpException $e) { $this->assertSame(403, $e->getStatusCode()); }
            $this->assertSame('pending', $order->fresh()->status);
        }
        $this->assertDatabaseCount('payments', 0);
    }
    public function test_reports_require_payment_by_the_current_user(): void
    {
        $order = $this->order(); $owner = User::find($order->user_id);
        $owner->forceFill(['is_subscribed' => 1, 'is_verified' => 1])->save();
        $this->actingAs($owner)->get('/pdf/123')->assertForbidden();
    }
    public function test_webhook_rejects_missing_or_invalid_signatures(): void
    {
        config(['services.stripe.webhook_secret' => 'whsec_test']);
        $this->post('/stripe/webhook', ['type' => 'checkout.session.completed'])->assertStatus(400);
        $this->assertDatabaseCount('payments', 0);
    }
}

