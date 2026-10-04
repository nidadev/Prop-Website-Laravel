@extends('layouts.app2')
@section('content')
<main class="container py-5">
<h1>Saved searches</h1>
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
@if(session('restore_search'))<form method="post" action="{{ url('/saved-searches/'.session('restore_search').'/restore') }}">@csrf<button class="btn btn-link">Undo removal</button></form>@endif
@forelse($searches as $search)
<section class="border rounded p-3 mb-3"><h2 class="h5">{{ $search->name }}</h2><p>{{ ucfirst($search->kind) }} pricing</p>
<form method="post" class="d-inline" action="{{ url('/saved-searches/'.$search->id.'/run') }}">@csrf<button class="btn btn-primary">Run saved search</button></form>
<form method="post" class="d-inline" action="{{ url('/saved-searches/'.$search->id.'/remove') }}">@csrf<button class="btn btn-outline-secondary">Remove</button></form>
</section>
@empty<p>Choose a state and county on Price Land or Price Houses, then select Save Search.</p>@endforelse
</main>
@endsection
