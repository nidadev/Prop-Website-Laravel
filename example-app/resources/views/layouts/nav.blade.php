<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<section id="header">
<nav class="navbar navbar-expand-md navbar-light bg-white shadow_box" id="navbar_sticky">
  <div class="container-xl">
    <a class="text-black p-0 navbar-brand fw-bold logo_position_rel" href="{{ url('/home') }}"> Prope <i class="fa fa-home col_blue me-1 logo_position_abs"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="col_red">Lyze</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	   <ul class="navbar-nav mb-0 nav_left">
        <!--li class="nav-item">
          <a class="nav-link " aria-current="page" href="{{ url('/') }}">Home</a>
        </li-->
		 
		<li class="nav-item">
          <a class="nav-link" href="{{ url('/priceland')}}">Price Land </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link" href="{{ url('/pricehouse') }}" id="navbarDropdown" role="button">
            Price Houses
          </a>
        </li>
		 
	
		<li class="nav-item">
          <a class="nav-link" href="{{ url('/compreport')}}" id="navbarDropdown" role="button">
            Comp Report
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/research')}}" role="button">
            Research
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/subscription')}}" role="button">
            Subscription
          </a>
        </li>
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Account
          </a>
          <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
         <li><a class="dropdown-item logout" href="{{ url('/api/logout')}}" id="lg"> Logout</a></li>
         <li><a class="dropdown-item" href="{{ url('/register')}}" id="rg"> Register</a></li>
		   <li><a class="dropdown-item" href="{{ url('/login')}}" id="ln"> Login</a></li>
        


          </ul>
        </li>

		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle dropdown_search nav_hide" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-search"></i>
          </a>
          <ul class="dropdown-menu drop_2 p-3" aria-labelledby="navbarDropdown">
            <li>
			  <div class="input-group">
				<input type="text" class="form-control" placeholder="Search Here">
				<span class="input-group-btn">
					<button class="btn btn-primary bg_yell rounded-0 p-2 px-3 border-0" type="button">
						<i class="fa fa-search"></i> </button>
				</span>
		</div>
			</li>
          </ul>
        </li>

      </ul>
      <ul class="navbar-nav mb-0 ms-auto">
		<li class="nav-item" id="login_b">
          <a class="nav-link button mx-3" href="{{ url('/login') }}"><i class="fa fa-user-plus me-1"></i>Login  </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</section>

<script>
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
                        $('#lg').show();
                        $('#rg').hide();
                        $('#ln').hide();
                        $("#login_b").remove();
                        //localStorage.removeItem('user_token');
                        //window.open('/login','_self');
                    }
                    else{
                        $("#lg").hide();
                        //$('#lg').hide();
                        alert(data.message);

                    }
                    },
                    statusCode: {
                    401: function() {
                        //alert("401");
                        $("#lg").remove();

                        
                    }
                },
    });
</script>
