<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
class RegistrationCaptcha {
    public function verify(Request $request): void {
        if (!config('services.recaptcha.enabled')) { return; }
        if (!config('services.recaptcha.secret') || !config('services.recaptcha.site_key')) {
            throw ValidationException::withMessages(['captcha'=>'Registration verification is temporarily unavailable. Contact support.']);
        }
        $token=$request->input('g-recaptcha-response');
        if (!is_string($token) || $token==='' || strlen($token)>4096) {
            throw ValidationException::withMessages(['captcha'=>'Complete the security check before registering.']);
        }
        try {
            $response=Http::asForm()->timeout(10)->post('https://www.google.com/recaptcha/api/siteverify',[
                'secret'=>config('services.recaptcha.secret'),'response'=>$token,
            ]);
            $result=$response->json();
            $valid=$response->successful() && ($result['success'] ?? false) === true
                && strtolower($result['hostname'] ?? '')===strtolower(parse_url(config('app.url'),PHP_URL_HOST) ?? '');
            $type=config('services.recaptcha.type','v2');
            if ($type === 'v3') {
                $score=$result['score'] ?? null; $minimum=config('services.recaptcha.minimum_score',0.5);
                $valid=$valid && ($result['action'] ?? '') === 'register'
                    && is_numeric($score) && is_finite((float)$score) && $score >= 0 && $score <= 1
                    && is_numeric($minimum) && $minimum >= 0 && $minimum <= 1 && $score >= $minimum;
            } elseif ($type !== 'v2') { $valid=false; }
        } catch (\Throwable $error) { $valid=false; }
        if (!$valid) { throw ValidationException::withMessages(['captcha'=>'The security check could not be verified. Please try again.']); }
    }
}
