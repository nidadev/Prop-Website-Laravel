@extends('layouts.app2')
@section('content')
<main class="container py-5"><div class="account-card mx-auto"><p class="eyebrow">Your Propelyze account</p><h1>Reset your password</h1><p>Enter your email address to request a password reset link.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('forgetPassword') }}">@csrf<label for="reset-email">Email address</label><input class="form-control mb-4" id="reset-email" type="email" name="email" autocomplete="email" value="{{ old('email') }}" maxlength="255" required><button class="btn btn-primary w-100">Send reset link</button></form><p class="mt-4"><a href="{{ url('/login') }}">Back to sign in</a></p></div></main>
@endsection
