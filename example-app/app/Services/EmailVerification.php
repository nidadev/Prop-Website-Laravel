<?php
namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class EmailVerification {
    public function send(User $user): void {
        $token = Str::random(64);
        DB::table('email_verification_tokens')->updateOrInsert(['user_id' => $user->id], [
            'email' => $user->email, 'token_hash' => hash('sha256', $token),
            'expires_at' => now()->addHour(), 'created_at' => now(), 'updated_at' => now(),
        ]);
        $data = ['email' => $user->email, 'url' => url('/verify-mail/'.$token),
            'title' => 'Email Verification', 'body' => 'Verify your email using this link within one hour.'];
        Mail::send('verifyEmail', ['data' => $data], fn ($message) => $message->to($user->email)->subject($data['title']));
    }
    public function consume(string $token): bool {
        return DB::transaction(function () use ($token) {
            $entry = DB::table('email_verification_tokens')->where('token_hash', hash('sha256', $token))->lockForUpdate()->first();
            if (!$entry || now()->gte($entry->expires_at)) { return false; }
            $user = User::query()->lockForUpdate()->find($entry->user_id);
            if (!$user || $user->email !== $entry->email) { return false; }
            $user->forceFill(['is_verified' => 1, 'email_verified_at' => now()])->save();
            DB::table('email_verification_tokens')->where('user_id', $user->id)->delete();
            return true;
        });
    }
}
