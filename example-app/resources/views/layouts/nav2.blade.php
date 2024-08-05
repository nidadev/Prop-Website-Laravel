<section id="header">
<nav class="navbar navbar-expand-md navbar-light bg-white shadow_box" id="navbar_sticky">
  <div class="container-xl">
    <a class="text-black p-0 navbar-brand fw-bold logo_position_rel" href="{{url('/')}}"> Prope <i class="fa fa-home col_blue me-1 logo_position_abs"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="col_red">Lyze</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
	   <ul class="navbar-nav mb-0 nav_left">
        <li class="nav-item">
          <a class="nav-link " aria-current="page" href="{{ url('/') }}">Home</a>
        </li>
		 
				<li class="nav-item">
          <a class="nav-link" href="#">Price Land </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Price Houses
          </a>
        </li>
		 
	
		<li class="nav-item">
          <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Comp Report
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ url('/research')}}" role="button">
            Research
          </a>
        </li>
		
		<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
		   <li><a class="dropdown-item" href="#"> Subscription</a></li>
       <li><a class="dropdown-item logout" href="{{ url('/logout')}}">Logout</a></li>
       <li><a class="dropdown-item border-0" href="{{ url('/research')}}"> Research</a></li>

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
     
    </div>
  </div>
</nav>
</section>