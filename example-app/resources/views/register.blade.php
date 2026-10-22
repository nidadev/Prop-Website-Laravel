@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg"><div class="center_om bg_backo"><div class="container-xl"><div class="row center_o1 m-auto text-center"><div class="col-md-12"><h2 class="text-white">Register</h2><h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Register</h6></div></div></div></div></section><section id="login" class="p_3"><div class="container-xl"><div class="login_1m p-4 w-50 mx-auto bg-light1"><h1>Create your account</h1><p>Start with your details. We will email you a link to verify your address.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form id="registration-form" method="post" action="{{ route('register') }}">@csrf
<label for="register-name">Name</label><input class="form-control mb-3" id="register-name" name="name" autocomplete="name" value="{{ old('name') }}" maxlength="255" required>
<label for="register-email">Email address</label><input class="form-control mb-3" id="register-email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" maxlength="255" required>
<label for="register-password">Password (at least 8 characters)</label><input class="form-control mb-3" id="register-password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label for="register-confirm">Confirm password</label><input class="form-control mb-3" id="register-confirm" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label class="d-block mb-4" for="register-agree"><input id="register-agree" name="agree" value="1" type="checkbox" required> I agree to the <a href="{{ url('/terms') }}">terms and conditions</a>.</label>
@if(config('services.recaptcha.enabled') && config('services.recaptcha.site_key'))
@if(config('services.recaptcha.type','v2') === 'v3')
<input type="hidden" name="g-recaptcha-response" id="registration-captcha-token">
<p class="small">Protected by reCAPTCHA. Google's <a href="https://policies.google.com/privacy">Privacy Policy</a> and <a href="https://policies.google.com/terms">Terms of Service</a> apply.</p>
<p id="registration-captcha-status" class="text-danger" role="alert"></p>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}" async defer></script>
<script>
document.addEventListener('DOMContentLoaded',()=>{
 const form=document.getElementById('registration-form'),tokenInput=document.getElementById('registration-captcha-token'),status=document.getElementById('registration-captcha-status');let attemptNumber=0;
 form.addEventListener('submit',event=>{
  event.preventDefault();if(!form.reportValidity())return;
  const button=form.querySelector('button[type="submit"],button:not([type])'),attempt=++attemptNumber;tokenInput.value='';status.textContent='';button.disabled=true;
  const fail=()=>{if(attempt!==attemptNumber)return;attemptNumber++;button.disabled=false;tokenInput.value='';status.textContent='Security verification could not complete. Please try again, or contact support.';};
  const timer=setTimeout(fail,15000);
  if(!window.grecaptcha||typeof grecaptcha.ready!=='function'){clearTimeout(timer);fail();return;}
  grecaptcha.ready(()=>{
   if(attempt!==attemptNumber)return;
   try{grecaptcha.execute({{ Illuminate\Support\Js::from(config('services.recaptcha.site_key')) }},{action:'register'}).then(token=>{
    if(attempt!==attemptNumber)return;clearTimeout(timer);if(!token){fail();return;}tokenInput.value=token;form.submit();
   }).catch(()=>{clearTimeout(timer);fail();});}catch(error){clearTimeout(timer);fail();}
  });
 });
});
</script>
@else
<div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div><script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endif
<button class="btn btn-primary w-100">Create account</button></form><p class="mt-4 mb-0">Already registered? <a href="{{ url('/login') }}">Sign in</a></p></div></div></section>
@endsection
