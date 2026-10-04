<?php
namespace App\Http\Controllers;
use App\Models\CheckoutOrder;
use App\Services\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\StripeClient;
class WalletController extends Controller {
    public function index(Wallet $wallet) {
        return view('credits', ['balance' => $wallet->balance(auth()->id()),
            'entries' => DB::table('wallet_entries')->where('user_id', auth()->id())->latest()->paginate(30)]);
    }
    public function topup(Request $request) {
        $request->validate(['amount' => 'required|integer|in:50,100,500,1000,2500']);
        $order = CheckoutOrder::create(['id' => (string) Str::uuid(), 'user_id' => auth()->id(),
            'service' => 'wallet_topup', 'property_ids' => [], 'amount' => (int) $request->amount]);
        try {
            $session = (new StripeClient(config('app.stripe_secret')))->checkout->sessions->create([
                'mode' => 'payment', 'client_reference_id' => (string) auth()->id(), 'metadata' => ['order_id' => $order->id],
                'customer_email' => auth()->user()->email,
                'line_items' => [['price_data' => ['currency' => 'usd', 'unit_amount' => $order->amount,
                    'product_data' => ['name' => 'Propelyze account credits']], 'quantity' => 1]],
                'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}', 'cancel_url' => url('/credits'),
            ], ['idempotency_key' => $order->id]);
            $order->update(['session_id' => $session->id]);
            return redirect()->away($session->url);
        } catch (\Throwable $error) {
            $order->update(['status' => 'failed']); report($error);
            return back()->with('error', 'Credit checkout could not be started. Please try again.');
        }
    }
}
