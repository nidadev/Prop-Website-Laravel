@extends('layouts.app2')
@section('content')
<main class="container-xl py-5"><p><a href="{{ url('/property-reports') }}">All owner/house reports</a></p><h1>{{ ucfirst($report->kind) }} and owner report</h1>
@if(session('success'))<p class="alert alert-success">{{ session('success') }}</p>@endif
@if(session('error'))<p class="alert alert-warning">{{ session('error') }}</p>@endif
@if($paid)<p class="d-flex flex-wrap gap-2">@foreach(['pdf'=>'Download PDF','csv'=>'Download CSV','kml'=>'Download KML'] as $format=>$label)<a class="btn btn-primary" href="{{ url('/property-reports/'.$report->id.'/'.$format) }}">{{ $label }}</a>@endforeach</p>
@else<form method="post" action="{{ route('stripe') }}">@csrf<input type="hidden" name="property_report_id" value="{{ $report->id }}"><button class="btn btn-primary">Purchase downloads (${{ number_format(app(\App\Services\PricingCatalog::class)->service('property_report')/100,2) }} or available report credit)</button></form>@endif
@include('partials.property-report-body')
</main>@endsection
