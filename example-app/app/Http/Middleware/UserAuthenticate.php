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
        if(Auth::check() && auth()->user()->is_subscribed == 0  && auth()->user()->is_verified == '1' && auth()->user()->usertype != 'admin')
        {
           return redirect('/subscription'); 

        }

        else if(Auth::check())
        {
            return $next($request);
        }

        return redirect('/login');
        //abort(401);
    }
}
