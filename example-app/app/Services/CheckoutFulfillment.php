<?php

namespace App\Services;

use App\Models\CheckoutOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class CheckoutFulfillment
{
    public function fulfill(object $session): CheckoutOrder
    {
        return DB::transaction(function () use ($session) {
            $order = CheckoutOrder::where('session_id', $session->id)->lockForUpdate()->firstOrFail();
            abort_unless($session->payment_status === 'paid'
                && $session->currency === 'usd'
                && (int) $session->amount_total >= $order->amount
                && (string) $session->client_reference_id === (string) $order->user_id
                && (string) ($session->metadata->order_id ?? '') === $order->id, 403);
            if ($order->status === 'paid') { return $order; }
            $payment = new Payment();
            $payment->forceFill([
                'payment_id' => $session->id, 'user_id' => $order->user_id,
                'product_name' => $order->service, 'quantity' => count($order->property_ids),
                'amount' => $session->amount_total / 100, 'currency' => $session->currency,
                'payer_name' => $session->customer_details->name ?? '',
                'payer_email' => $session->customer_details->email ?? '',
                'payment_status' => 'paid', 'payment_method' => 'Stripe',
            ])->save();
            $order->update(['status' => 'paid']);
            if ($order->service === 'wallet_topup') {
                app(Wallet::class)->change($order->user_id, $order->amount, 'topup:'.$order->id, 'Account credit purchase');
            }
            if ($order->service === 'list_upload') {
                $upload = DB::table('list_uploads')->where('id', $order->list_upload_id)->where('user_id', $order->user_id)->lockForUpdate()->first();
                abort_unless($upload, 404);
                if ($upload->status === 'awaiting_payment') {
                    DB::table('list_uploads')->where('id', $upload->id)->update(['status' => 'queued', 'updated_at' => now()]);
                    \App\Jobs\PriceApnList::dispatch($upload->id)->afterCommit();
                }
            }
            return $order;
        });
    }
}
