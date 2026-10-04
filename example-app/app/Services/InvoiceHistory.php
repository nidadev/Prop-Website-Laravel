<?php

namespace App\Services;

use App\Models\BillingAccount;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class InvoiceHistory
{
    public function paid(object $invoice): void
    {
        DB::transaction(function () use ($invoice) {
            $account = BillingAccount::where('customer_id', $invoice->customer)->lockForUpdate()->first();
            if (!$account || $invoice->status !== 'paid' || $invoice->currency !== 'usd') { return; }
            if (Payment::where('payment_id', $invoice->id)->exists()) { return; }
            (new Payment())->forceFill(['payment_id' => $invoice->id, 'user_id' => $account->user_id,
                'product_name' => 'Subscription invoice', 'quantity' => 1, 'amount' => $invoice->amount_paid / 100,
                'currency' => $invoice->currency, 'payer_name' => $invoice->customer_name ?? '',
                'payer_email' => $invoice->customer_email ?? '', 'payment_status' => 'paid', 'payment_method' => 'Stripe'])->save();
        });
    }
}
