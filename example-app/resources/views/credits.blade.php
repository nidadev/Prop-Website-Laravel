@extends('layouts.app2')
@section('content')
@if(!config('services.stripe.enabled', true))<p class="container mt-4 alert alert-warning" role="status">Payment checkout is temporarily unavailable while our payment connection is confirmed.</p>@endif
<main class="container py-5 content-prose"><h1>Account credits</h1>
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
@if(session('error'))<p role="alert">{{ session('error') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert">{{ $error }}</p>@endforeach
<p>Available balance: <strong>${{ number_format($balance / 100, 2) }}</strong></p>
<p>Use credits for small APN pricing lists. Credits have no expiry. Rows without a verified valuation are credited back automatically.</p>
@if(str_starts_with(config('app.stripe_secret', ''), 'sk_test_'))<p class="alert alert-warning">Payments are in test mode. Test credits have no cash value. Use Stripe test payment details only.</p>@endif
<form action="{{ url('/credits/topup') }}" method="post">@csrf<label for="credit-amount">Add credits</label>
<select class="form-select mb-3" id="credit-amount" name="amount">@foreach([50,100,500,1000,2500] as $amount)<option value="{{ $amount }}">${{ number_format($amount/100,2) }}</option>@endforeach</select>
<button class="btn btn-primary">Continue to secure checkout</button></form>
<h2 class="mt-4">Credit history</h2><div class="table-responsive"><table class="table"><thead><tr><th>Date</th><th>Description</th><th>Amount</th></tr></thead><tbody>
@forelse($entries as $entry)<tr><td>{{ $entry->created_at }}</td><td>{{ $entry->description }}</td><td>${{ number_format($entry->amount/100,2) }}</td></tr>@empty<tr><td colspan="3">No credit transactions yet.</td></tr>@endforelse
</tbody></table></div>{{ $entries->links() }}</main>
@endsection
