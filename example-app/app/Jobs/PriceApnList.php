<?php

namespace App\Jobs;

use App\Services\PrycdClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class PriceApnList implements ShouldQueue
{
    use Queueable;
    public $tries = 1;
    public $timeout = 840;
    public function __construct(public int $uploadId) {}

    public function middleware(): array
    {
        return [(new \Illuminate\Queue\Middleware\WithoutOverlapping('price-list-'.$this->uploadId))->dontRelease()->expireAfter(900)];
    }

    public function handle(PrycdClient $client): void
    {
        $upload = DB::table('list_uploads')->find($this->uploadId);
        if (!$upload || !in_array($upload->status, ['queued', 'processing'], true)) { return; }
        $order = DB::table('checkout_orders')->where('list_upload_id', $this->uploadId)->where('user_id', $upload->user_id)->where('service', 'list_upload')->where('status', 'paid')->first();
        if (!$order) { return; }
        DB::table('list_uploads')->where('id', $upload->id)->update(['status' => 'processing', 'updated_at' => now()]);
        foreach (DB::table('list_upload_rows')->where('list_upload_id', $upload->id)->where('status', 'pending')->orderBy('id')->limit(5)->get() as $row) {
            // Claim each row before requesting paid data; replayed jobs skip claimed rows.
            if (!DB::table('list_upload_rows')->where('id', $row->id)->where('status', 'pending')->update(['status' => 'processing', 'updated_at' => now()])) { continue; }
            try {
                $result = $client->priceLand($row->apn, $row->county_fips);
                $result['comparables'] = app(\App\Services\ComparableRecords::class)->forParcel($row->apn, $row->county_fips, $result, $client);
                DB::table('list_upload_rows')->where('id', $row->id)->update(['status' => 'completed', 'result' => json_encode($result), 'error' => null, 'updated_at' => now()]);
            } catch (\Throwable $e) {
                DB::table('list_upload_rows')->where('id', $row->id)->update(['status' => 'needs_review', 'error' => 'No verified valuation returned. Contact support for review.', 'updated_at' => now()]);
                $this->refundRow($order, $row->id, $upload->record_count);
            }
        }
        if (DB::table('list_upload_rows')->where('list_upload_id', $upload->id)->where('status', 'pending')->exists()) {
            self::dispatch($upload->id)->delay(now()->addSeconds(5));
            return;
        }
        $needsReview = DB::table('list_upload_rows')->where('list_upload_id', $upload->id)->where('status', '!=', 'completed')->exists();
        DB::table('list_uploads')->where('id', $upload->id)->update(['status' => $needsReview ? 'completed_with_issues' : 'completed', 'updated_at' => now()]);
        try {
            $user = \App\Models\User::find($upload->user_id);
            if ($user) { \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ListPricingCompleted($upload->id, $needsReview)); }
        } catch (\Throwable $error) { report($error); }
    }

    private function refundRow(object $order, int $rowId, int $count): void
    {
        if ($count > 0) {
            app(\App\Services\Wallet::class)->change($order->user_id, intdiv($order->amount, $count),
                'pricing-refund:'.$order->id.':'.$rowId, 'Unpriced APN row credited back');
        }
    }

    public function failed(?\Throwable $error): void
    {
        $upload = DB::table('list_uploads')->find($this->uploadId);
        if (!$upload) { return; }
        $order = DB::table('checkout_orders')->where('list_upload_id', $upload->id)->where('user_id', $upload->user_id)->where('status', 'paid')->where('service', 'list_upload')->first();
        if (!$order) { return; }
        foreach (DB::table('list_upload_rows')->where('list_upload_id', $upload->id)->where('status', '!=', 'completed')->lazyById(100) as $row) {
            DB::table('list_upload_rows')->where('id', $row->id)->update(['status' => 'needs_review', 'error' => 'Pricing did not finish. The row cost has been credited back.', 'updated_at' => now()]);
            $this->refundRow($order, $row->id, $upload->record_count);
        }
        DB::table('list_uploads')->where('id', $upload->id)->update(['status' => 'completed_with_issues', 'updated_at' => now()]);
    }
}

