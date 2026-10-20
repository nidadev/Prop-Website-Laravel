@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg"><div class="center_om bg_backo"><div class="container-xl"><div class="row center_o1 m-auto text-center"><div class="col-md-12"><h2 class="text-white">Login</h2><h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Login</h6></div></div></div></div></section><section id="login" class="p_3"><div class="container-xl"><div class="login_1m p-4 w-50 mx-auto bg-light1"><h1>Sign in</h1><p>Continue your property research and view your saved work.</p>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('userLogin') }}">@csrf
<label for="login-email">Email address</label><input class="form-control mb-3" id="login-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" maxlength="255" required>
<label for="login-password">Password</label><input class="form-control mb-3" id="login-password" type="password" name="password" autocomplete="current-password" maxlength="128" required>
<div class="d-flex justify-content-between flex-wrap gap-2 mb-4"><label><input type="checkbox" name="remember" value="1"> Remember me</label><a href="{{ route('forget') }}">Forgot password?</a></div>
<button class="btn btn-primary w-100">Sign in</button></form><p class="mt-4 mb-0">New to Propelyze? <a href="{{ url('/register') }}">Create an account</a></p></div></div></section>
@endsection
