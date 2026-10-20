<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class DataTreeAvailable {
    public function handle(Request $request, Closure $next) {
        if (!config('property.datatree_enabled', true)) {
            if ($request->expectsJson()) { return response()->json(['message' => 'Property data access is temporarily unavailable.'], 503); }
            return response()->view('data-unavailable', [], 503);
        }
        return $next($request);
    }
}
