@extends('layouts.app2')
@section('content')
<main class="container py-5">
<h1>Upload an APN list</h1>
<p>Use a CSV or Excel XLSX file with columns state, county_fips and apn. Use two-letter states and five-digit county codes. Keep APNs as text to preserve leading zeros. Maximum 25,000 records.</p>
<p>We will validate the file and show its record count before payment. Land pricing costs ${{ number_format(app(\App\Services\PricingCatalog::class)->service('list_upload') / 100, 2) }} per record.</p>
@foreach($errors->all() as $error)<p role="alert">{{ $error }}</p>@endforeach
<form method="post" enctype="multipart/form-data" action="{{ url('/list-upload') }}">@csrf
<label for="apn-file">Choose a file</label><input type="file" id="apn-file" name="file" accept=".csv,.xlsx" required>
<button class="btn btn-primary">Validate list</button></form>
<h2 class="mt-4">Your uploads</h2>
@forelse($uploads as $upload)<p><a href="{{ url('/list-upload/'.$upload->id) }}">Upload {{ $upload->id }}</a> — {{ $upload->record_count }} {{ \Illuminate\Support\Str::plural("record", $upload->record_count) }} — {{ \Illuminate\Support\Str::headline($upload->status) }}</p>
@empty<p>No lists uploaded yet.</p>@endforelse
</main>
@endsection
