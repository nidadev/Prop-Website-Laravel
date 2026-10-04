<?php

namespace App\Http\Controllers;

use App\Models\CheckoutOrder;
use App\Services\CheckoutFulfillment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Webhook;

class CheckoutController extends Controller
{
    public function stripe(Request $request)
    {
        $upload = null;
        if ($request->filled('land_valuation_id')) {
            $request->validate(['land_valuation_id' => 'required|integer|min:1']);
            $valuation = \Illuminate\Support\Facades\DB::table('land_valuations')->where('user_id', auth()->id())->where('id', $request->land_valuation_id)->first();
            abort_unless($valuation, 404);
            $ids = [(string) $valuation->id]; $service = 'land_report';
        } elseif ($request->filled('upload_id')) {
            $request->validate(['upload_id' => 'required|integer|min:1']);
            $upload = \Illuminate\Support\Facades\DB::table('list_uploads')->where('user_id', auth()->id())->where('id', $request->upload_id)->first();
            abort_unless($upload, 404);
            if (!config('prycd.enabled') || !config('prycd.key')) {
                return back()->with('error', 'List pricing is unavailable until the data provider is connected. No payment has been taken.');
            }
            abort_unless($upload->status === 'awaiting_payment', 422);
            if ($upload->record_count > app(\App\Services\ProviderBudget::class)->remaining('pricing')) {
                return back()->with('error', 'The available data allowance is too small for this list. Contact support before placing an order. No payment has been taken.');
            }
            $ids = \Illuminate\Support\Facades\DB::table('list_upload_rows')->where('list_upload_id', $upload->id)->pluck('id')->map(fn ($id) => (string) $id)->all();
            $service = 'list_upload';
        } else {
        $request->validate(['exp_data_download' => 'required|array|min:1', 'exp_data_download.*' => 'required|string|max:100000']);
        $ids = array_values(array_unique(array_filter(explode(',', implode(',', $request->exp_data_download)))));
        abort_unless(count($ids) >= 1 && count($ids) <= 25000, 422);
        foreach ($ids as $id) { abort_unless(ctype_digit($id), 422, 'Invalid property selection.'); }
        $service = $request->boolean('pdf_check') ? 'comp_report' : 'owner_export';
        }
        if ($service === 'comp_report') { abort_unless(count($ids) === 1, 422); }
        if (in_array($service, ['comp_report', 'owner_export'], true) && !config('property.datatree_enabled', true)) {
            return back()->with('error', 'Property reports and owner exports are temporarily unavailable while data access is confirmed. No payment has been taken.');
        }
        if (in_array($service, ['comp_report', 'land_report'], true)) {
            $grant = app(\App\Services\ReportAllowance::class)->claim(auth()->id(), $ids, $service);
            if ($grant && $service === 'land_report') { return redirect('/land-valuation/'.$ids[0])->with('success', 'A report credit has been applied. Your PDF is ready.'); }
            if ($grant) { return view('payment_success', ['data' => $ids[0], 'pdf_check' => 1]); }
        }
        $unitAmount = app(\App\Services\PricingCatalog::class)->service($service);
        $account = \App\Models\BillingAccount::where('user_id', auth()->id())->first();
        if ($service === 'owner_export' && $account && $account->hasAccess() && $account->plan === 'gold') {
            $unitAmount = 7;
        }
        if (count($ids) * $unitAmount < 50) {
            if ($service === 'list_upload') {
                return $this->payListWithCredits($upload, $ids, $unitAmount);
            }
            return back()->with('error', 'The minimum card payment is $0.50. Select at least '.(int) ceil(50 / $unitAmount).' records.');
        }
        if (!config('services.stripe.enabled', true)) {
            return response()->view('payments-unavailable', [], 503);
        }
        $order = CheckoutOrder::create([
            'id' => (string) Str::uuid(), 'user_id' => auth()->id(), 'service' => $service,
            'property_ids' => $ids, 'amount' => count($ids) * $unitAmount,
            'list_upload_id' => $upload?->id,
        ]);
        try {
            $session = (new StripeClient(config('app.stripe_secret')))->checkout->sessions->create([
                'mode' => 'payment', 'client_reference_id' => (string) auth()->id(),
                'metadata' => ['order_id' => $order->id],
                'customer_email' => auth()->user()->email,
                'line_items' => [['price_data' => [
                    'currency' => 'usd', 'unit_amount' => $unitAmount,
                    'product_data' => ['name' => match ($service) { 'comp_report' => 'Comp report', 'land_report' => 'Land valuation PDF', 'list_upload' => 'APN list pricing', default => 'Owner record export' }],
                ], 'quantity' => count($ids)]],
                'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ], ['idempotency_key' => $order->id]);
            $order->update(['session_id' => $session->id]);
            return redirect()->away($session->url);
        } catch (\Throwable $e) {
            $order->update(['status' => 'failed']);
            report($e);
            return back()->with('error', 'Checkout could not be started. Please try again.');
        }
    }

    public function success(Request $request, CheckoutFulfillment $fulfillment)
    {
        $request->validate(['session_id' => 'required|string|max:255']);
        $order = CheckoutOrder::where('session_id', $request->session_id)->where('user_id', auth()->id())->firstOrFail();
        $session = (new StripeClient(config('app.stripe_secret')))->checkout->sessions->retrieve($order->session_id);
        if ($session->payment_status !== 'paid') {
            return redirect('/exports')->with('error', 'Payment is still pending. Please check again shortly.');
        }
        $order = $fulfillment->fulfill($session);
        if ($order->service === 'wallet_topup') {
            return redirect('/credits')->with('success', 'Your account credits are ready.');
        }
        if ($order->service === 'land_report') {
            return redirect('/land-valuation/'.$order->property_ids[0])->with('success', 'Payment confirmed. Your PDF is ready.');
        }
        if ($order->service === 'list_upload') {
            return redirect('/list-upload/'.$order->list_upload_id)->with('success', 'Payment confirmed. Your list is queued for pricing.');
        }
        return view('payment_success', ['data' => implode(',', $order->property_ids), 'pdf_check' => $order->service === 'comp_report' ? 1 : null]);
    }

    public function cancel() { return redirect('/exports')->with('error', 'Checkout was cancelled.'); }

    private function payListWithCredits(object $upload, array $ids, int $unitAmount)
    {
        $cost = count($ids) * $unitAmount;
        if (app(\App\Services\Wallet::class)->balance(auth()->id()) < $cost) {
            return redirect('/credits')->with('error', 'Add account credits, then return to your list to start pricing.');
        }
        \Illuminate\Support\Facades\DB::transaction(function () use ($upload, $ids, $cost) {
            $current = \Illuminate\Support\Facades\DB::table('list_uploads')->where('id', $upload->id)->where('user_id', auth()->id())->lockForUpdate()->first();
            abort_unless($current && $current->status === 'awaiting_payment', 422);
            $order = CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => auth()->id(), 'service' => 'list_upload',
                'property_ids' => $ids, 'amount' => $cost, 'list_upload_id' => $upload->id, 'status' => 'paid']);
            app(\App\Services\Wallet::class)->change(auth()->id(), -$cost, 'list:'.$order->id, 'APN list '.$upload->id.' pricing');
            \Illuminate\Support\Facades\DB::table('list_uploads')->where('id', $upload->id)->update(['status' => 'queued', 'updated_at' => now()]);
            \App\Jobs\PriceApnList::dispatch($upload->id)->afterCommit();
        });
        return redirect('/list-upload/'.$upload->id)->with('success', 'Credits applied. Your list is queued for pricing.');
    }

    public function webhook(Request $request, CheckoutFulfillment $fulfillment)
    {
        $secret = config('services.stripe.webhook_secret');
        abort_unless($secret, 503);
        try { $event = Webhook::constructEvent($request->getContent(), $request->header('Stripe-Signature', ''), $secret); }
        catch (\Throwable $e) { return response('Invalid signature', 400); }
        if (in_array($event->type, ['checkout.session.completed', 'checkout.session.async_payment_succeeded'], true)
            && $event->data->object->mode === 'payment' && $event->data->object->payment_status === 'paid') {
            $fulfillment->fulfill($event->data->object);
        }
        if (in_array($event->type, ['customer.subscription.created', 'customer.subscription.updated', 'customer.subscription.deleted'], true)) {
            $subscription = (new StripeClient(config('app.stripe_secret')))->subscriptions->retrieve($event->data->object->id);
            app(\App\Services\SubscriptionSync::class)->sync($subscription);
        }
        if ($event->type === 'invoice.paid') { app(\App\Services\InvoiceHistory::class)->paid($event->data->object); }
        return response('OK');
    }
}
