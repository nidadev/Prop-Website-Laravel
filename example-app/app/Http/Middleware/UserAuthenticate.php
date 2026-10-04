<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) { return redirect('/login'); }
        abort_if(auth()->user()->is_banned, 403, 'This account has been suspended. Contact support.');
        if (!auth()->user()->is_verified) {
            if ($request->expectsJson()) { return response()->json(['message' => 'Verify your email before using property services.'], 403); }
            return redirect('/profile')->with('error', 'Verify your email before using property services.');
        }
        if (auth()->user()->usertype === 'admin') { return $next($request); }
        $account = \App\Models\BillingAccount::where('user_id', auth()->id())->first();
        if ($account ? !$account->hasAccess() : !auth()->user()->is_subscribed) {
            if ($request->expectsJson()) { return response()->json(['message' => 'An active subscription is required.'], 403); }
            return redirect('/subscription');
        }
        return $next($request);
    }
}
