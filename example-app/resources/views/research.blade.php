@extends('layouts.app2')
@section('content')
<main class="container-xl py-5"><p class="eyebrow">Location research</p><h1>Explore your market</h1><p>Use the dashboard filters and map to compare locations and identify counties for further research.</p>
<div class="d-flex flex-wrap gap-3 mb-4"><a class="btn btn-primary" href="{{ url('/land-comps') }}">Find land comparables</a><a class="btn btn-outline-primary" href="{{ url('/land-valuation') }}">Price a land parcel</a><a class="btn btn-outline-primary" href="{{ url('/saved-searches') }}">Saved searches</a></div>
@if(!config('property.datatree_enabled', true))<p class="alert alert-info">Property searches and owner records are temporarily unavailable. Market research and PRYCD land tools remain available within their data allowance.</p>@endif
<iframe src="{{ $siteSettings['research_embed_url'] ?? 'https://public.tableau.com/views/MarketResearch_17207118833230/Sheet1?:showVizHome=no&:embed=true' }}" title="Propelyze market research dashboard" width="100%" height="850" loading="lazy" style="border:1px solid #dce5e8;border-radius:16px;" allowfullscreen></iframe>
<p class="small text-muted mt-3">Dashboard data is provided through Tableau Public. Check the dashboard's source and update dates when comparing markets.</p></main>
@endsection
