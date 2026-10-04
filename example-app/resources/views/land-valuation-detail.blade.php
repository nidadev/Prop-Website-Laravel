@extends('layouts.app2')
@section('content')
@if(config('services.stripe.enabled', true) && str_starts_with(config('app.stripe_secret', ''), 'sk_test_'))<p class="container mt-4 alert alert-warning" role="status">Payments are in test mode. Use Stripe test payment details only; real payments are not available yet.</p>@endif
@if(!config('services.stripe.enabled', true))<p class="container mt-4 alert alert-warning" role="status">Payment checkout is temporarily unavailable while our payment connection is confirmed.</p>@endif
<main class="container py-5 content-prose"><p class="eyebrow">Land valuation</p><h1>Parcel {{ $valuation->apn }}</h1>
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
@if(session('error'))<p role="alert">{{ session('error') }}</p>@endif
<p>County FIPS: {{ $valuation->county_fips }}</p><div class="feature-card mb-4"><p>Estimated market value</p><h2>${{ number_format($result['market_value'], 2) }}</h2>
@if($result['price_per_acre'] ?? null)<p>${{ number_format($result['price_per_acre'], 2) }} per acre</p>@endif
@if($result['acres'] ?? null)<p>Acreage: {{ $result['acres'] }}</p>@endif
<p>Source: {{ $result['source'] }} · Model: {{ $result['model'] ?? 'Provider model' }} · Confidence: {{ $result['confidence'] ?? 'Not supplied' }}</p><p>Data retrieved: {{ $result['retrieved_at'] }}</p></div>
<p>This is an automated land valuation, not an appraisal. Confirm parcel identity, access, condition, zoning and current comparable sales before making an offer.</p>
@if($paid)<a class="btn btn-primary" href="{{ url('/land-valuation/'.$valuation->id.'/pdf') }}">Download land valuation PDF</a>
@else<form action="{{ route('stripe') }}" method="post">@csrf<input type="hidden" name="land_valuation_id" value="{{ $valuation->id }}"><button class="btn btn-primary">Get PDF report — ${{ number_format(app(\App\Services\PricingCatalog::class)->service('land_report')/100,2) }}</button></form><p>Available Gold report credits are applied before payment.</p>@endif
<p class="mt-3"><a href="{{ url('/land-valuation') }}">Back to saved valuations</a></p></main>
@endsection
