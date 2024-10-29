@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
  <div class="center_om bg_backo">
    <div class="container-xl">
      <div class="row center_o1 m-auto text-center">
        <div class="col-md-12">
          <h2 class="text-white">Register</h2>

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
        <div class="login_1m p-4 w-50 mx-auto bg-light1">
          <h2 class="text-center mb-3">Register </h2>
          @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
        <p class="result"> @if(Session::has('success')) {{ Session::get('success') }} @endif</p>

          <form method="post" action="{{ url('register') }}">
            @csrf
            <h6 class="mb-3 ">Name</h6>
            <input class="form-control" type="text" name="name" autocomplete="on" placeholder="Enter Name:">
            <span class="error name_err">@error('name') {{$message}} @enderror</span>
             <span class="error phone_err"></span>
            <h6 class="mb-3  mt-4">Email</h6>
            <input class="form-control" type="email" name="email" autocomplete="on" placeholder="Enter email:">
            <span class="error email_err">@error('email') {{$message}} @enderror</span>
            <h6 class="mb-3  mt-4">Password</h6>
            <input class="form-control" type="password" name="password" autocomplete="on" placeholder="Enter Password:">
            <span class="error password_err">@error('password') {{$message}} @enderror</span>
            <h6 class="mb-3  mt-4">Confirm Password</h6>
            <!--input class="form-control" placeholder="Password" type="Password"-->
            <input class="form-control" type="password" name="password_confirmation" autocomplete="on" placeholder="Enter Confirm Password:">
            <span class="error password_confirmation_err">@error('password_confirmation') {{$message}} @enderror</span>

            <div class="form-check mt-3">
              <input type="checkbox" class="form-check-input" style="border:2px solid #ccc;" id="customCheck1" name="agree" value="yes">
              <label class="form-check-label" for="customCheck1">Agree to our <a class="" href="#">terms & conditions</a></label>
              <span class="error agree_err">@error('agree') {{$message}} @enderror</span>
            </div>
            <h6 class="mt-3 center_sm"><button type="submit" style="border:none;" class="button_2 b-block text-center reg">SIGN UP</button></h6>
            <p class="mt-3 mb-0 text-center">Already have an account? <a class=" col_blue" href="{{ url('/login') }} "> Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

<style>
  span,
  .error {
    color: red;
  }

  p.result {
    color: green;
  }
</style>
</body>

</html>