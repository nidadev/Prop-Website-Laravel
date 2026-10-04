@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg"><div class="center_om bg_backo"><div class="container-xl"><div class="row center_o1 m-auto text-center"><div class="col-md-12"><h2 class="text-white">Forgot Password</h2><h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Forgot Password</h6></div></div></div></div></section><section id="login" class="p_3"><div class="container-xl"><div class="login_1m p-4 w-50 mx-auto bg-light1"><h1>Reset your password</h1><p>Enter your email address to request a password reset link.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('forgetPassword') }}">@csrf<label for="reset-email">Email address</label><input class="form-control mb-4" id="reset-email" type="email" name="email" autocomplete="email" value="{{ old('email') }}" maxlength="255" required><button class="btn btn-primary w-100">Send reset link</button></form><p class="mt-4"><a href="{{ url('/login') }}">Back to sign in</a></p></div></div></section>
@endsection
