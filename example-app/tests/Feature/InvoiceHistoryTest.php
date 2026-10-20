<?php

namespace Tests\Feature;

use App\Models\BillingAccount;
use App\Models\User;
use App\Services\InvoiceHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceHistoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_repeated_paid_invoice_notifications_write_once_to_the_customer_owner(): void
    {
        $owner = User::factory()->create();
        BillingAccount::create(['user_id' => $owner->id, 'customer_id' => 'cus_owner']);
        $invoice = (object) ['id' => 'in_paid', 'customer' => 'cus_owner', 'status' => 'paid', 'currency' => 'usd', 'amount_paid' => 2499];
        $service = app(InvoiceHistory::class);
        $service->paid($invoice); $service->paid($invoice);
        $this->assertDatabaseCount('payments', 1);
        $this->assertDatabaseHas('payments', ['user_id' => $owner->id, 'payment_id' => 'in_paid', 'amount' => 24.99]);
        $invoice->id = 'in_unknown'; $invoice->customer = 'cus_unknown';
        $service->paid($invoice);
        $this->assertDatabaseCount('payments', 1);
    }
}
