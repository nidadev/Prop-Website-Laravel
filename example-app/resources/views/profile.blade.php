@extends('layouts.app2')

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
    <button class="logout">Logout</button>
        <div class="agent_dt2 row mt-4">
            <div class="col-md-8">
                <div class="agent_dt2l">
                    <div class="detail_1l2 p-4 rounded_10 bg-white">
                        <h4>About <span class="name"></span></h4>
                        <p class="mt-3">Good road frontage on a paved county road with utilities make it an amazing setting for your dream country getaway! If you like views, you must see this property!,</p>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="agent_dt2r">
                </div>
                <div class="blog_1r1 p-4 bg-white rounded_10 mt-4">
                    <h5>Contact</h5>
                    <hr>
                    <h6 class="font_14"><i class="fa fa-building-o  col_blue me-1"></i> <a href="#">Office <span class="pull-right">+123 4567 890</span></a></h6>
                    <h6 class="mt-4  font_14"><i class="fa fa-mobile  col_blue me-1"></i> <a href="#">Mobile <span class="pull-right">+123 4567 890</span></a></h6>
                    <h6 class="mt-4 font_14"><i class="fa fa-phone  col_blue me-1"></i> <a href="#">Fax <span class="pull-right">+123 4567 890</span></a></h6>
                    <h6 class="mt-4 font_14"><i class="fa fa-globe  col_blue me-1"></i> <a href="#">Website <span class="pull-right">info@gmail.com</span></a></h6>
                    <h6 class="mt-4 font_14"><i class="fa fa-map-marker  col_blue me-1"></i> <a href="#">Address <span class="pull-right">1699 Lorem Clvf</span></a></h6>
                    <h6 class="mt-4 mb-0 font_14"><i class="fa fa-envelope  col_blue me-1"></i> <a href="#">Email <span class="pull-right">info@gmail.com</span></a></h6>
                </div>
             
                
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
        $.ajax({
                    url: '{{ url("/api/profile") }}',
                    type: "GET",
                    headers: {'Authorization':localStorage.getItem('user_token2')},
                    success: function(data) {
                        console.log(data);
                        if(data.status == true)
                    {
                        console.log(data.user);
                        $('.name').text(data.user.name);
                        $('#name').val(data.user.name);
                        $('#email').val(data.user.email);
                        //localStorage.removeItem('user_token');
                        //window.open('/login','_self');
                    }
                    else{
                        //alert(data.message);

                    }
                    }
    });

    //////////////////

    $('.logout').click(function(){
        $.ajax({
                    url: '{{ url("/api/logout")}}',
                    type: "POST",
                    headers: {'Authorization':localStorage.getItem('user_token2')},
                    success: function(data) {
                        console.log(data);
                        if(data.success == true)
                    {
                        localStorage.removeItem('user_token2');
                        window.open('/login','_self');
                    }
                    else{
                        alert(data.message);

                    }
                    }
    });
});

    });
    </script>
</body>

</html>