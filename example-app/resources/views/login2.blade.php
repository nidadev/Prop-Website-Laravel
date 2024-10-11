@extends('layouts.app')

@section('main')
<section id="center" class="center_reg">
   <div class="center_om bg_backo">
     <div class="container-xl">
  <div class="row center_o1 m-auto text-center">
     <div class="col-md-12">
	         <h2 class="text-white">Login</h2>
		  <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Register </h6>
	 </div>
  </div>
 </div>
   </div>   
</section>
<section id="login" class="p_3">
 <div class="container-xl">
  <div class="row login_1">
    <div class="col-md-12">
      <div class="login_1m p-4 w-50 mx-auto bg-light">
	      <h2 class="text-center mb-3">Login </h2>
        <!--form method="post" action="{{ url('/login') }}" id="login_id"-->
        
        @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif

          <form method="post" action="{{ route('userLogin') }}">
          @csrf
          <h6 class="mb-3 fw-bold">Email</h6>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email:" maxlength="40">Enter Email:
            <span class="error email_err">@error('email') {{$message}} @enderror</span>
            <h6 class="mb-3 fw-bold mt-4">Password</h6>
            <input type="password" class="form-control" name="password" placeholder="Enter Password:" maxlength="40">Enter password:
            <span class="error password_err">@error('password') {{$message}} @enderror</span>
            <div class="login_1mi row mt-3">
		    <div class="col-md-6 col-6">
			  <div class="login_1mil">
			    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="customCheck1">
        <label class="form-check-label" for="customCheck1">Remember Me</label>
    
    </div>
			  </div>
			</div>
			<div class="col-md-6 col-6">
			  <div class="login_1mir text-end">
			    <h6 class="mb-0"><a href="#">Forgot Password?</a></h6>
			  </div>
			</div>
		  </div>
		  <h6 class="mt-3 center_sm">  <p class="result"></p>  
          <button type="submit" style="border:none;" class="button_2 b-block text-center" >LOGIN</button></h6>
		  <p class="mt-3 mb-0 text-center">Don't have an account? <a class="fw-bold a_tag col_blue" href="{{ url('/register') }} ">Create One</a></p>
		</div>
            </form>
   </div>
  </div>
 </div>
</section>
@endsection

<style>
    span,
    .incorrect {
        color: red;
    }

    p.result {
        color: green;
    }
</style>



