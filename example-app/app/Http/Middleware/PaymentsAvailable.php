<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class PaymentsAvailable {
    public function handle(Request $request, Closure $next) {
        if (!config('services.stripe.enabled', true)) {
            return $request->expectsJson() ? response()->json(['message' => 'Payment checkout is temporarily unavailable.'], 503)
                : response()->view('payments-unavailable', [], 503);
        }
        return $next($request);
    }
}
