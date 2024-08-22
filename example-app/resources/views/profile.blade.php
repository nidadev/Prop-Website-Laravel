@extends('layouts.app')

@section('main')
<section id="center" class="center_agent_dt">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">Profile Details</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Agent Details </h6>
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
                        <p class="error1" style="color:red"></p>
                        <h4>Welcome <span class="name"></span></h4>
                        <div class="email_verify">
                            <p>Email:<span class="email"></span> &nbsp; <span class="verify"></span></p>
                            <p class="result1" style="color:green"></p>
                        </div>
                    </div>
                    <form method="post" action="{{ url('/profile-update') }}" id="profile_form">
                        <input type="hidden" value="" name="id" id="user_id">


                </div>
            </div>
            <div class="col-md-4">
                <div class="agent_dt2r">
                </div>
                <div class="blog_1r1 p-4 bg-white rounded_10 mt-4">
                    <h5>Update Settings</h5>
                    <hr>
                    <h6 class="font_14"><i class="fa fa-building-o  col_blue me-1"></i> <a href="#">Name
                            <input class="form-control" type="text" name="name" id="name"><span class="pull-right error name_err"></span></a></h6>
                    <h6 class="mt-4 font_14"><i class="fa fa-globe  col_blue me-1"></i> <a href="#">Email <input class="form-control" type="text" name="email" id="email"><span class="pull-right error email_err"></span></a></h6>
                    <!--h6 class="font_14"><i class="fa fa-building-o  col_blue me-1"></i> <a href="#">Phone <input class="form-control" type="text" name="phone" id="phone"><span class="pull-right error phone_err"></span></a></h6-->
                    <span></p><input type="submit" style="border:none" class="button" value="Update"> </span>
                    <p class="result"></p>
                </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    </div>
    <?php

    ?>
</section>
@endsection

<style>
    .error,p .error1
    .incorrect {
        color: red;
    }

    p.result {
        color: green;
    }
</style>
</body>

</html>