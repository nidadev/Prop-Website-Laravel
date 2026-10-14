@extends('layouts.app2')
@section('content')
<main class="container py-5">
<h1>APN list {{ $upload->id }}</h1>
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
@if(session('error'))<p role="alert">{{ session('error') }}</p>@endif
<p>{{ $upload->record_count }} records. Status: {{ $upload->status }}.</p>
<p>Pricing requires matching parcel data and current comparable records. Results will identify records that need review.</p>
<p>Failed pricing rows are returned as <a href="{{ url('/credits') }}">account credits</a>. Provider allowance remaining this period: {{ app(\App\Services\ProviderBudget::class)->remaining('pricing') }} properties.</p>
@if($upload->status === 'awaiting_payment')
<p>Land pricing: ${{ number_format($upload->record_count * app(\App\Services\PricingCatalog::class)->service('list_upload') / 100, 2) }} for {{ $upload->record_count }} records.</p>
<form method="post" action="{{ route('stripe') }}">@csrf<input type="hidden" name="upload_id" value="{{ $upload->id }}"><button class="btn btn-primary" @disabled(!config('prycd.enabled') || !config('prycd.key'))>Pay and price list</button></form>
@if(!config('prycd.enabled') || !config('prycd.key'))<p>List pricing is temporarily unavailable. Your validated list is saved; no payment is required yet.</p>@endif
@endif
@if(in_array($upload->status, ['completed', 'completed_with_issues']))<p><a class="btn btn-primary" href="{{ url('/list-upload/'.$upload->id.'/download') }}">Download pricing results</a> <a class="btn btn-outline-primary" href="{{ url('/list-upload/'.$upload->id.'/comparables') }}">Download comparable breakdown</a></p>@endif
<div class="table-responsive"><table class="table"><thead><tr><th>State</th><th>County FIPS</th><th>APN</th><th>Status</th><th>Result</th></tr></thead><tbody>
@foreach($rows as $row)@php($result = json_decode($row->result ?? '{}', true))<tr><td>{{ strtoupper($row->state) }}</td><td>{{ $row->county_fips }}</td><td>{{ $row->apn }}</td><td>{{ $row->status }}</td><td>@if(isset($result['market_value']))${{ number_format($result['market_value'], 2) }} — {{ $result['source'] ?? '' }}<details class="mt-2"><summary>Comparable records ({{ count($result['comparables']['records'] ?? []) }})</summary>@include('partials.comparable-records')</details>@else{{ $row->error }}@endif</td></tr>@endforeach
</tbody></table></div>{{ $rows->links() }}
</main>
@endsection
