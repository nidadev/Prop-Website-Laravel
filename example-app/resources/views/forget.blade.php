@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
   <div class="center_om bg_backo">
     <div class="container-xl">
  <div class="row center_o1 m-auto text-center">
     <div class="col-md-12">
	         <h2 class="text-white">Forget Password</h2>
		  <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Forget Password </h6>
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
	      <h2 class="text-center mb-3">Forget </h2>
        <!--form method="post" action="{{ url('/login') }}" id="login_id"-->
        
        @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
        @if(Session::has('success'))
        <p class="result">{{ Session::get('success') }}</p>

        @endif

          <form method="post" action="{{ route('forgetPassword') }}">
          @csrf
          <h6 class="mb-3 ">Email</h6>
          <input type="email" class="form-control" id="" name="email" placeholder="Enter Email:" maxlength="40">
            <span class="error email_err">@error('email') {{$message}} @enderror</span>
                <div class="login_1mi row mt-3">
		    
			
		  </div>
		  <h6 class="mt-3 center_sm">  <p class="result"></p>  
          <button type="submit" style="border:none;" class="button_2 b-block text-center" >Submit</button></h6>
          <p class="mt-3 mb-0 text-center"><a class=" a_tag col_blue" href="{{ url('/login') }} ">Login</a></p>

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



