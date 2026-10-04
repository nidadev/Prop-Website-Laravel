@extends('layouts.app2')
@section('content')
<main class="container py-5 content-prose"><p class="eyebrow">Land research</p><h1>Price a land parcel</h1>
<p>Enter the parcel APN and its five-digit county FIPS code to request a PRYCD land valuation. This tool does not provide house valuations or owner records.</p>
@if(session('error'))<p class="alert alert-warning" role="alert">{{ session('error') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert">{{ $error }}</p>@endforeach
<p>Provider allowance remaining: {{ app(\App\Services\ProviderBudget::class)->remaining('pricing') }} properties this period. Reopening a saved valuation does not use a request.</p>
<form method="post" action="{{ url('/land-valuation') }}">@csrf
<label for="valuation-apn">Parcel APN</label><input class="form-control mb-3" id="valuation-apn" name="apn" value="{{ old('apn') }}" required maxlength="100">
<label for="valuation-county">County FIPS (five digits, including state code)</label><input class="form-control mb-3" id="valuation-county" name="county_fips" value="{{ old('county_fips') }}" required pattern="[0-9]{5}" maxlength="5" inputmode="numeric">
<button class="btn btn-primary">Get land valuation</button></form>
<h2 class="mt-4">Your saved valuations</h2><div class="table-responsive"><table class="table"><thead><tr><th>APN</th><th>County FIPS</th><th>Saved</th><th></th></tr></thead><tbody>
@forelse($valuations as $row)<tr><td>{{ $row->apn }}</td><td>{{ $row->county_fips }}</td><td>{{ $row->created_at }}</td><td><a href="{{ url('/land-valuation/'.$row->id) }}">View valuation</a></td></tr>@empty<tr><td colspan="4">No valuations yet.</td></tr>@endforelse
</tbody></table></div>{{ $valuations->links() }}</main>
@endsection
