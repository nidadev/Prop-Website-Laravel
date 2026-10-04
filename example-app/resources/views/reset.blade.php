@extends('layouts.app2')
@section('content')
<main class="container py-5"><div class="account-card mx-auto"><p class="eyebrow">Your Propelyze account</p><h1>Choose a new password</h1>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('resetPassword') }}">@csrf<input type="hidden" name="email" value="{{ $email }}"><input type="hidden" name="token" value="{{ $token }}">
<label for="new-password">New password (at least 8 characters)</label><input class="form-control mb-3" id="new-password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label for="confirm-password">Confirm new password</label><input class="form-control mb-4" id="confirm-password" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="128" required><button class="btn btn-primary w-100">Reset password</button></form></div></main>
@endsection
