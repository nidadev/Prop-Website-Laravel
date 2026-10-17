<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ContactSpamProtection
{
    public function challenge(): array
    {
        $a = random_int(2, 9); $b = random_int(2, 9);
        return ['question' => "$a + $b", 'token' => Crypt::encryptString(json_encode([
            'answer' => $a + $b, 'issued' => now()->timestamp, 'nonce' => (string) Str::uuid(),
        ]))];
    }

    public function verify(Request $request): bool
    {
        // Quietly discard the observed campaign and fields meant only for bots.
        if ($request->filled('company_website') || strtolower(preg_replace('/[^a-z]/i', '', (string) $request->input('name'))) === 'robertesove') {
            return false;
        }
        try {
            $token = $request->input('contact_token');
            if (!is_string($token) || strlen($token) > 2048) { throw new \RuntimeException(); }
            $challenge = json_decode(Crypt::decryptString($token), true, 512, JSON_THROW_ON_ERROR);
            $age = now()->timestamp - ($challenge['issued'] ?? 0);
            $answer = $request->input('contact_answer');
            if ($age < 3 || $age > 7200 || !is_scalar($answer) || !preg_match('/^\d{1,2}$/', (string) $answer)
                || (int) $answer !== ($challenge['answer'] ?? null) || empty($challenge['nonce'])) { throw new \RuntimeException(); }
        } catch (\Throwable $e) {
            throw ValidationException::withMessages(['contact_answer' => 'Please reload the contact page, answer the quick check, and try again.']);
        }
        $keys = ['contact:ip:'.hash('sha256', (string) $request->ip()) => [5, 3600],
            'contact:email:'.hash('sha256', strtolower(trim((string) $request->input('email')))) => [3, 3600],
            'contact:day:'.hash('sha256', (string) $request->ip()) => [20, 86400]];
        foreach ($keys as $key => [$limit, $decay]) {
            if (RateLimiter::tooManyAttempts($key, $limit)) {
                throw ValidationException::withMessages(['comment' => 'Too many enquiries have been submitted. Please try again later.']);
            }
        }
        if (!Cache::add('contact:used:'.hash('sha256', $challenge['nonce']), true, 7200)) {
            throw ValidationException::withMessages(['contact_answer' => 'This enquiry was already submitted. Reload the page to send a new enquiry.']);
        }
        foreach ($keys as $key => [$limit, $decay]) { RateLimiter::hit($key, $decay); }
        return true;
    }
}
