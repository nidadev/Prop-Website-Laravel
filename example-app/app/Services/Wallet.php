<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;
class Wallet {
    public function balance(int $user): int { return (int) DB::table('wallets')->where('user_id', $user)->value('balance'); }
    public function change(int $user, int $amount, string $reference, string $description): void {
        DB::transaction(function () use ($user, $amount, $reference, $description) {
            DB::table('wallets')->insertOrIgnore(['user_id' => $user, 'balance' => 0, 'created_at' => now(), 'updated_at' => now()]);
            $wallet = DB::table('wallets')->where('user_id', $user)->lockForUpdate()->first();
            if (DB::table('wallet_entries')->where('reference', $reference)->exists()) { return; }
            if ($wallet->balance + $amount < 0) {
                throw \Illuminate\Validation\ValidationException::withMessages(['credits' => 'Add account credits before continuing.']);
            }
            DB::table('wallet_entries')->insert(['user_id' => $user, 'amount' => $amount, 'reference' => $reference,
                'description' => $description, 'created_at' => now(), 'updated_at' => now()]);
            DB::table('wallets')->where('user_id', $user)->update(['balance' => $wallet->balance + $amount, 'updated_at' => now()]);
        });
    }
}
