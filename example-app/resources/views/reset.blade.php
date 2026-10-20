@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg"><div class="center_om bg_backo"><div class="container-xl"><div class="row center_o1 m-auto text-center"><div class="col-md-12"><h2 class="text-white">Reset Password</h2><h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Reset Password</h6></div></div></div></div></section><section id="login" class="p_3"><div class="container-xl"><div class="login_1m p-4 w-50 mx-auto bg-light1"><h1>Choose a new password</h1>@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status" class="alert alert-success">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert" class="text-danger">{{ $error }}</p>@endforeach

<form method="post" action="{{ route('resetPassword') }}">@csrf<input type="hidden" name="email" value="{{ $email }}"><input type="hidden" name="token" value="{{ $token }}">
<label for="new-password">New password (at least 8 characters)</label><input class="form-control mb-3" id="new-password" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="128" required>
<label for="confirm-password">Confirm new password</label><input class="form-control mb-4" id="confirm-password" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" maxlength="128" required><button class="btn btn-primary w-100">Reset password</button></form></div></div></section>
@endsection
