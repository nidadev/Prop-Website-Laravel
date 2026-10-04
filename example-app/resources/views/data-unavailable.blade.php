@extends('layouts.app2')
@section('content')
<main class="container py-5 content-prose"><p class="eyebrow">Property data</p><h1>Data access is temporarily unavailable</h1>
<p>We are confirming access with our property data provider. Property searches, owner exports, and detailed property reports will return when that connection is ready.</p>
<p>No payment has been taken for this request.</p><a href="{{ url('/research') }}" class="btn btn-primary">Explore market research</a> <a href="{{ url('/support') }}" class="btn btn-outline-primary">Contact support</a></main>
@endsection
