@extends('layouts.app2')
@section('content')
<style>
.billing-page{max-width:1160px;padding:40px 12px 48px}.billing-page h1{margin-bottom:10px}.billing-page .billing-intro{color:#606475;margin-bottom:24px}
.billing-page .billing-status,.billing-page .billing-rates,.billing-page .billing-history{border:1px solid #e4e1f1;border-radius:12px;padding:24px;margin-top:24px}.billing-page .billing-status{background:#faf9ff}.billing-page .billing-status p{margin-bottom:14px}
.billing-page .billing-plans{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px;margin:28px 0}.billing-page .billing-plan{display:flex;flex-direction:column;min-width:0;border:1px solid #e4e1f1;border-radius:12px;padding:24px;background:white}.billing-page .billing-plan.is-current{border:2px solid #6c60fe;padding:23px}
.billing-page .billing-plan h2{font-size:23px;margin:0 0 16px}.billing-page .billing-price{font-size:28px;font-weight:600;margin-bottom:4px}.billing-page .billing-price span{font-size:14px;font-weight:400;color:#606475}.billing-page .billing-trial{font-size:13px;color:#606475;margin-bottom:20px}.billing-page .billing-features{flex:1}.billing-page .billing-features p{font-size:14px;line-height:1.7;border-top:1px solid #eee;padding-top:14px;margin-bottom:14px}.billing-page .billing-plan form{margin-top:auto}.billing-page .billing-plan .btn{width:100%;padding:11px 14px}.billing-page .billing-badge{font-size:12px;background:#eeeaff;color:#5043b9;padding:5px 10px;border-radius:20px;align-self:flex-start;margin-bottom:16px}
.billing-page .billing-rates p{font-size:14px;margin-bottom:12px}.billing-page .billing-rates h2,.billing-page .billing-history h2{font-size:23px;margin-bottom:18px}.billing-page .billing-rate-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:18px}.billing-page .billing-rate-grid strong{display:block}.billing-page .billing-history table{margin:0}.billing-page .billing-history th{white-space:nowrap}
@media(max-width:991px){.billing-page .billing-rate-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.billing-page .billing-plans{gap:14px}.billing-page .billing-plan{padding:18px}.billing-page .billing-plan.is-current{padding:17px}}
@media(max-width:767px){.billing-page{padding-top:28px}.billing-page .billing-plans{grid-template-columns:1fr}.billing-page .billing-status,.billing-page .billing-rates,.billing-page .billing-history{padding:18px}.billing-page .billing-status .btn{width:100%}}
</style>
@php $hasSubscription = $account && $account->subscription_id && $account->hasAccess(); @endphp
@if(!config('services.stripe.enabled', true))<p class="container mt-4 alert alert-warning" role="status">Payment checkout is temporarily unavailable while our payment connection is confirmed.</p>@endif
<main class="container billing-page">
    <h1>Plans and billing</h1>
    <p class="billing-intro">View your plan, manage billing and review payment history.</p>
@if(str_starts_with(config('app.stripe_secret', ''), 'sk_test_'))<p class="alert alert-warning">Payments are in test mode. Use Stripe test payment details only.</p>@endif
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
    @if(session('error'))<p role="alert">{{ session('error') }}</p>@endif
    @if($account && $account->subscription_id)
        <section class="billing-status" aria-label="Current subscription"><p>Current plan: {{ config('pricing.plans.'.$account->plan.'.name', 'Subscription') }}. Status: {{ $account->status }}.</p>
        <form method="post" action="{{ url('/billing/portal') }}">@csrf
            <button class="btn btn-primary">Manage subscription</button>
        </form></section>
    @endif
    <div class="billing-plans">
    @foreach($plans as $key => $plan)
        @php $isCurrent = $hasSubscription && $account->plan === $key; @endphp
        <section class="billing-plan {{ $isCurrent ? 'is-current' : '' }}"><h2>{{ $plan['name'] }}</h2>
            @if($isCurrent)<span class="billing-badge">Current plan</span>@endif
            <p class="billing-price">${{ number_format($plan['amount']/100, 2) }} <span>/ {{ $plan['interval'] }}</span></p>
            <p class="billing-trial">{{ config('pricing.trial_days', 14) }}-day trial for new subscribers</p>
            <div class="billing-features">
            <p>Research, location search, valuation and viewing comparables.</p>
            @if($key !== 'bronze')<p>Comparable exports, polygon search and list scrubbing.</p>@endif
            @if($key === 'gold')<p>20 comp report credits per calendar month when you visit the Comp Report page. Unused credits carry over.</p>@endif
            </div>
            @if($isCurrent)
                <button class="btn btn-outline-primary" disabled>Current plan</button>
            @elseif($hasSubscription)
                <form method="post" action="{{ url('/billing/portal') }}">@csrf<button class="btn btn-primary">Change plan</button></form>
            @else
            <form method="post" action="{{ url('/create-subscription') }}">@csrf
                <input type="hidden" name="plan" value="{{ $key }}"><button class="btn btn-primary">Choose {{ $plan['name'] }}</button>
            </form>
            @endif
        </section>
    @endforeach
    </div>
    <section class="billing-rates">
        <h2>Additional service rates</h2>
        <div class="billing-rate-grid">
            <p><strong>Comp reports</strong>${{ number_format(app(\App\Services\PricingCatalog::class)->service('comp_report') / 100, 2) }} per report</p>
            <p><strong>Owner record exports</strong>${{ number_format(app(\App\Services\PricingCatalog::class)->service('owner_export') / 100, 2) }} per record<br>$0.07 per record for Gold</p>
            <p><strong>List upload pricing</strong>${{ number_format(app(\App\Services\PricingCatalog::class)->service('list_upload') / 100, 2) }} per record</p>
            <p><strong>Skip tracing</strong>${{ number_format(app(\App\Services\PricingCatalog::class)->service('skip_trace') / 100, 2) }} per record</p>
        </div>
        <p class="text-muted mb-0">Service availability depends on the connected data provider. Some services are currently unavailable.</p>
    </section>
    <section class="billing-history">
        <h2>Payment history</h2>
        @if($payments->isNotEmpty())
        <div class="table-responsive"><table class="table"><thead><tr><th scope="col">Date</th><th scope="col">Description</th><th scope="col">Amount</th><th scope="col">Status</th></tr></thead><tbody>
        @foreach($payments as $payment)<tr><td>{{ $payment->created_at->format('M j, Y') }}</td><td>{{ $payment->product_name }}</td><td>${{ number_format($payment->amount, 2) }}</td><td>{{ ucfirst($payment->payment_status) }}</td></tr>@endforeach
        </tbody></table></div>
        @else<p class="text-muted mb-0">No payments yet.</p>@endif
    </section>
</main>
@endsection
