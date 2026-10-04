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
            $valid=$response->successful() && ($result['success'] ?? false)
                && strtolower($result['hostname'] ?? '')===strtolower(parse_url(config('app.url'),PHP_URL_HOST) ?? '');
        } catch (\Throwable $error) { $valid=false; }
        if (!$valid) { throw ValidationException::withMessages(['captcha'=>'The security check could not be verified. Please try again.']); }
    }
}
