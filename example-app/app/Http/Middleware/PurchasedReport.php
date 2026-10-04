<?php

namespace App\Http\Middleware;

use App\Models\CheckoutOrder;
use Closure;
use Illuminate\Http\Request;

class PurchasedReport
{
    public function handle(Request $request, Closure $next, string $service)
    {
        $selection = $request->route('id') ?? $request->route('pricehouseid') ?? $request->input('userIds', []);
        $ids = array_values(array_unique(array_filter(explode(',', implode(',', (array) $selection)))));
        abort_unless(count($ids) > 0, 422);
        $allowed = CheckoutOrder::where('user_id', auth()->id())->where('service', $service)->where('status', 'paid')
            ->get()->flatMap(fn ($order) => $order->property_ids)->map(fn ($id) => (string) $id)->all();
        abort_unless(count(array_diff($ids, $allowed)) === 0, 403, 'Payment is required for this selection.');
        return $next($request);
    }
}
