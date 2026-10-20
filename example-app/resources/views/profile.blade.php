@extends('layouts.app2')
@section('content')
<main class="container py-5">
    <h1>Your profile</h1>
    @if(session('success'))<p role="status">{{ session('success') }}</p>@endif
    @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form method="post" action="{{ url('/profile-update') }}">
        @csrf
        <label for="profile-name">Name</label>
        <input class="form-control mb-3" id="profile-name" name="name" value="{{ old('name', auth()->user()->name) }}" required maxlength="255">
        <label for="profile-email">Email</label>
        <input class="form-control mb-3" type="email" id="profile-email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        <button class="btn btn-primary">Save profile</button>
    </form>
    @if(!auth()->user()->is_verified)
        <form method="post" action="{{ url('/send-verify-mail') }}" class="mt-3">@csrf<button class="btn btn-secondary">Resend verification email</button></form>
    @endif
</main>
@endsection
