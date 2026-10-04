@extends('layouts.app2')
@section('content')
@if(!config('services.stripe.enabled', true))<p class="container mt-4 alert alert-warning" role="status">Payment checkout is temporarily unavailable while our payment connection is confirmed.</p>@endif
<main class="container py-5">
    <h1>Plans and billing</h1>
@if(str_starts_with(config('app.stripe_secret', ''), 'sk_test_'))<p class="alert alert-warning">Payments are in test mode. Use Stripe test payment details only.</p>@endif
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
    @if(session('error'))<p role="alert">{{ session('error') }}</p>@endif
    @if($account && $account->subscription_id)
        <p>Current plan: {{ config('pricing.plans.'.$account->plan.'.name', 'Subscription') }}. Status: {{ $account->status }}.</p>
        <form method="post" action="{{ url('/billing/portal') }}">@csrf
            <button class="btn btn-primary">Change plan or card and manage cancellation</button>
        </form>
    @endif
    <div class="row mt-4">
    @foreach($plans as $key => $plan)
        <section class="col-md-4 mb-3"><h2>{{ $plan['name'] }}</h2>
            <p>${{ number_format($plan['amount']/100, 2) }} per {{ $plan['interval'] }}. 14 day trial for new subscribers.</p>
            <p>Research, location search, valuation and viewing comparables.</p>
            @if($key !== 'bronze')<p>Comparable exports, polygon search and list scrubbing.</p>@endif
            @if($key === 'gold')<p>20 comp report credits per calendar month when you visit the Comp Report page. Unused credits carry over.</p>@endif
            <form method="post" action="{{ url('/create-subscription') }}">@csrf
                <input type="hidden" name="plan" value="{{ $key }}"><button class="btn btn-primary">Choose {{ $plan['name'] }}</button>
            </form>
        </section>
    @endforeach
    </div>
    <p>Comp reports ${{ number_format(app(\App\Services\PricingCatalog::class)->service('comp_report') / 100, 2) }} each. Owner record exports ${{ number_format(app(\App\Services\PricingCatalog::class)->service('owner_export') / 100, 2) }} per record, or $0.07 for Gold. List upload pricing ${{ number_format(app(\App\Services\PricingCatalog::class)->service('list_upload') / 100, 2) }} per record. Skip tracing ${{ number_format(app(\App\Services\PricingCatalog::class)->service('skip_trace') / 100, 2) }} per record.</p>
    <h2>Payment history</h2>
    @forelse($payments as $payment)<p>{{ $payment->created_at->format('M j, Y') }} — {{ $payment->product_name }} — ${{ number_format($payment->amount, 2) }} — {{ $payment->payment_status }}</p>
    @empty<p>No payments yet.</p>@endforelse
</main>
@endsection
