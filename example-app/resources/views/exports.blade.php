@extends('layouts.app2')
@section('content')
<main class="container py-5">
    <h1>Your report exports</h1>
    @forelse($exports as $export)
        <div class="border-bottom py-3">
            <span>{{ $export->created_at->format('M j, Y') }}</span>
            <span>{{ $export->status }}</span>
            @if($export->file_name)
                <a href="{{ route('download.export', ['fileName' => $export->file_name]) }}">Download {{ $export->file_name }}</a>
            @endif
        </div>
    @empty
        <p>You have no report exports yet.</p>
    @endforelse
</main>
@endsection
