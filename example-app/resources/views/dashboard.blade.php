@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">Profile</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Profile </h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="agent_dt" class="p_3 bg-light">
    <div class="container-xl">
        <!--button class="logout">Logout</button-->
        <div class="agent_dt2 row mt-4">
            <div class="col-md-8">
                <div class="agent_dt2l">
                    <div class="detail_1l2 p-4 rounded_10 bg-white">
                        <h4>Welcome {{ auth()->user()->name }}</h4>
                        <div class="email_verify">
                            <p>{{ auth()->user()->email }}
                                @if(auth()->user()->is_verified == 0)
                                <button class="button verify_mail" data-id="{{ auth()->user()->email }}" style="border:none;" href="">Verify</button>
                                </p>
                                @else
                                <span class="verify">Verified</span>
                                @endif
                            <p class="result1" style="color:green"></p>
                        </div>
                    </div>
                    <form method="post" action="{{ url('/profile-update') }}" id="profile_form">
                        @csrf
                        <input type="hidden" value="" name="id" id="user_id">


                </div>
            </div>
            <!--div class="col-md-4">
                <div class="agent_dt2r">
                </div>
                <div class="blog_1r1 p-4 bg-white rounded_10 mt-4">
                    <h5>Update Settings</h5>
                    @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
        <p class="result"> @if(Session::has('success')) {{ Session::get('success') }} @endif</p>
                    <hr>
                    <h6 class="font_14"><i class="fa fa-building-o  col_blue me-1"></i> <a href="#">Name
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" >
                            <span class="error name_err">@error('name') {{$message}} @enderror</span>
                            </a></h6>
                    <h6 class="mt-4 font_14"><i class="fa fa-globe  col_blue me-1"></i> <a href="#">Email <input class="form-control" type="text" name="email" id="email" value="{{ old('email') }}"> <span class="error email_err">@error('email') {{$message}} @enderror</span>
                        </a></h6>
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                    <span></p><input type="submit" style="border:none" class="button" value="Update"> </span>
                    <p class="result"></p>
                </div>

                </form>

            </div>
        </div-->
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