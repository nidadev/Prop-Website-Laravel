@extends('layouts.app2')
@section('content')
<main class="container py-5"><div class="account-card mx-auto"><p class="eyebrow">Your Propelyze account</p><h1>Sign in</h1><p>Continue your property research and view your saved work.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('userLogin') }}">@csrf
<label for="login-email">Email address</label><input class="form-control mb-3" id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" maxlength="255" required>
<label for="login-password">Password</label><input class="form-control mb-3" id="login-password" type="password" name="password" autocomplete="current-password" maxlength="128" required>
<div class="d-flex justify-content-between flex-wrap gap-2 mb-4"><label><input type="checkbox" name="remember" value="1"> Remember me</label><a href="{{ route('forget') }}">Forgot password?</a></div>
<button class="btn btn-primary w-100">Sign in</button></form><p class="mt-4 mb-0">New to Propelyze? <a href="{{ url('/register') }}">Create an account</a></p></div></main>
@endsection
