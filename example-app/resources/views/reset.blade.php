@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
   <div class="center_om bg_backo">
     <div class="container-xl">
  <div class="row center_o1 m-auto text-center">
     <div class="col-md-12">
	         <h2 class="text-white">Reset Password</h2>
		  <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Reset Password </h6>
	 </div>
  </div>
 </div>
   </div>   
</section>
<section id="login" class="p_3">
 <div class="container-xl">
  <div class="row login_1">
    <div class="col-md-12">
      <div class="login_1m p-4 w-50 mx-auto bg-light1">
	      <h2 class="text-center mb-3">Reset </h2>
        <!--form method="post" action="{{ url('/login') }}" id="login_id"-->
        
        @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
        @if(Session::has('success'))
        <p class="result">{{ Session::get('success') }}</p>

        @endif

          <form method="post" action="{{ route('resetPassword') }}">
          @csrf
          <input type="hidden" name="id" value="{{ $user[0]['id'] }}">
          <h6 class="mb-3 ">Password</h6>
          <input type="password" class="form-control" id="" name="password" placeholder="Enter Password:" maxlength="40">
            <span class="error email_err">@error('password') {{$message}} @enderror</span>
            <input type="password" class="form-control" id="" name="password_confirmation" placeholder="Enter Confirm Password:" maxlength="40">

                <div class="login_1mi row mt-3">
		    
			
		  </div>
		  <h6 class="mt-3 center_sm">  <p class="result"></p>  
          <button type="submit" style="border:none;" class="button_2 b-block text-center" >Submit</button></h6>

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



