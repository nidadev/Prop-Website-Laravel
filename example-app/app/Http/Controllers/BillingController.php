<?php

namespace App\Http\Controllers;

use App\Models\BillingAccount;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class BillingController extends Controller
{
    public function index()
    {
        $account = BillingAccount::where('user_id', auth()->id())->first();
        $payments = Payment::where('user_id', auth()->id())->latest()->limit(30)->get();
        return view('billing', ['account' => $account, 'plans' => app(\App\Services\PricingCatalog::class)->plans(), 'payments' => $payments]);
    }

    public function checkout(Request $request)
    {
        $request->validate(['plan' => 'required|string']);
        return \Illuminate\Support\Facades\Cache::lock('subscription-checkout-'.auth()->id(), 60)->block(5,
            fn () => $this->createCheckout($request));
    }

    private function createCheckout(Request $request)
    {
        $request->validate(['plan' => 'required|string']);
        $plan = app(\App\Services\PricingCatalog::class)->plans()[$request->plan] ?? null;
        abort_unless(is_array($plan), 422);
        $account = BillingAccount::firstOrCreate(['user_id' => auth()->id()], ['trial_used' => (bool) auth()->user()->is_subscribed]);
        if ($account->subscription_id && $account->hasAccess()) { return $this->portal(); }
        $stripe = new StripeClient(config('app.stripe_secret'));
        if ($account->checkout_session_id) {
            $pending = $stripe->checkout->sessions->retrieve($account->checkout_session_id);
            if ($pending->status === 'complete') {
                app(\App\Services\SubscriptionSync::class)->sync($stripe->subscriptions->retrieve($pending->subscription));
                return redirect('/subscription')->with('success', 'Your subscription is already active.');
            }
            if ($pending->status === 'open' && $account->checkout_plan === $request->plan) {
                return redirect()->away($pending->url);
            }
            if ($pending->status === 'open') {
                $stripe->checkout->sessions->expire($pending->id);
            }
            $account->update(['checkout_attempt' => null, 'checkout_session_id' => null]);
        }
        if (!$account->checkout_attempt) {
            $account->update(['checkout_attempt' => (string) \Illuminate\Support\Str::uuid(), 'checkout_plan' => $request->plan]);
        } elseif ($account->checkout_plan !== $request->plan) {
            return redirect('/subscription')->with('error', 'Please resume your previous plan checkout first. It can then be cancelled before choosing another plan.');
        }
        if (!$account->customer_id) {
            $customer = $stripe->customers->create(['email' => auth()->user()->email,
                'metadata' => ['user_id' => (string) auth()->id()]], ['idempotency_key' => 'propelyze-customer-'.$account->id]);
            $account->update(['customer_id' => $customer->id]);
        }
        $subscription = ['metadata' => ['user_id' => (string) auth()->id(), 'plan' => $request->plan, 'price_version' => (string) $plan['version_id']]];
        if (!$account->trial_used) { $subscription['trial_period_days'] = config('pricing.trial_days'); }
        $price = app(\App\Services\StripeCatalog::class)->price($request->plan, $plan, $stripe);
        $session = $stripe->checkout->sessions->create([
            'mode' => 'subscription', 'customer' => $account->customer_id,
            'client_reference_id' => (string) auth()->id(), 'subscription_data' => $subscription,
            'line_items' => [['quantity' => 1, 'price' => $price->price_id]],
            'success_url' => url('/billing/return').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('/subscription'),
        ], ['idempotency_key' => 'propelyze-subscription-'.$account->checkout_attempt]);
        $account->update(['checkout_session_id' => $session->id, 'checkout_plan' => $request->plan,
            'checkout_url' => $session->url, 'checkout_expires_at' => \Illuminate\Support\Carbon::createFromTimestamp($session->expires_at)]);
        return redirect()->away($session->url);
    }

    public function returned(Request $request)
    {
        $request->validate(['session_id' => 'required|string|max:255']);
        $stripe = new StripeClient(config('app.stripe_secret'));
        $session = $stripe->checkout->sessions->retrieve($request->session_id);
        $account = BillingAccount::where('user_id', auth()->id())->firstOrFail();
        abort_unless($session->mode === 'subscription' && $session->status === 'complete'
            && (string) $session->client_reference_id === (string) auth()->id()
            && $session->customer === $account->customer_id, 403);
        app(\App\Services\SubscriptionSync::class)->sync($stripe->subscriptions->retrieve($session->subscription));
        return redirect('/dashboard')->with('success', 'Your subscription is ready.');
    }

    public function portal()
    {
        $account = BillingAccount::where('user_id', auth()->id())->firstOrFail();
        abort_unless($account->customer_id, 422);
        $stripe = new StripeClient(config('app.stripe_secret'));
        $session = $stripe->billingPortal->sessions->create([
            'customer' => $account->customer_id, 'return_url' => url('/billing/sync'),
            'configuration' => app(\App\Services\StripeCatalog::class)->portalConfiguration($stripe),
        ]);
        return redirect()->away($session->url);
    }

    public function sync()
    {
        $account = BillingAccount::where('user_id', auth()->id())->firstOrFail();
        if ($account->subscription_id) {
            $subscription = (new StripeClient(config('app.stripe_secret')))->subscriptions->retrieve($account->subscription_id);
            app(\App\Services\SubscriptionSync::class)->sync($subscription);
        }
        return redirect('/subscription')->with('success', 'Billing details refreshed.');
    }
}
