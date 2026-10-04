@extends('layouts.app2')
@section('content')
<main class="container py-5"><div class="account-card mx-auto"><p class="eyebrow">Your Propelyze account</p><h1>Create your account</h1><p>Start with your details. We will email you a link to verify your address.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('register') }}">@csrf
<label for="register-name">Name</label><input class="form-control mb-3" id="register-name" name="name" autocomplete="name" value="{{ old('name') }}" maxlength="255" required>
<label for="register-email">Email address</label><input class="form-control mb-3" id="register-email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" maxlength="255" required>
<label for="register-password">Password (at least 8 characters)</label><input class="form-control mb-3" id="register-password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label for="register-confirm">Confirm password</label><input class="form-control mb-3" id="register-confirm" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label class="d-block mb-4" for="register-agree"><input id="register-agree" name="agree" value="1" type="checkbox" required> I agree to the <a href="{{ url('/terms') }}">terms and conditions</a>.</label>
@if(config('services.recaptcha.enabled') && config('services.recaptcha.site_key'))<div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div><script src="https://www.google.com/recaptcha/api.js" async defer></script>@endif
<button class="btn btn-primary w-100">Create account</button></form><p class="mt-4 mb-0">Already registered? <a href="{{ url('/login') }}">Sign in</a></p></div></main>
@endsection
