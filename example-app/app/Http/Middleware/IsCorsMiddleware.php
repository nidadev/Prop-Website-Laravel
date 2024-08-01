<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //echo 'nida cors';
        return $next($request)->header('Access-Control-Allow-Origin', '*');
       // ->header('Access-Control-Allow-Origin','*')
        //->header('Access-Control-Allow-Methods','PUT,GET,POST,DELETE,OPTIONS')
       // ->header('Access-Control-Allow-Headers','Accept,Content-Type');
    }
}
