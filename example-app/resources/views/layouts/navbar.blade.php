<section id="header">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
  <a class="text-black p-0 navbar-brand fw-bold logo_position_rel" href="{{ url('/home') }}"> PROPE <i class="fa fa-home col_blue me-1 logo_position_abs"></i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="col_red">LYZE</span></a>

  <!--a class="text-black p-0 navbar-brand fw-bold logo_position_rel" href="{{ url('/home') }}"><img src="{{ asset('img/logo.png') }}" width="245px" height="38px" class="img-fluid" alt="abc"></a-->
    <!--a class="navbar-brand" href="{{ route('home') }}">Home</a-->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        @if(auth()->user() && auth()->user()->is_subscribed == 1)
       
        <li class="nav-item">
          <a class="nav-link {{ Route::is('compreport') ? 'active' : '' }}" aria-current="page" href="{{ route('compreport') }}">CompReport</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('research') ? 'active' : '' }}" aria-current="page" href="{{ route('research') }}">Research</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('pricehouse') ? 'active' : '' }}" aria-current="page" href="{{ route('pricehouse') }}">Pricehouse</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('priceland') ? 'active' : '' }}" aria-current="page" href="{{ route('priceland') }}">PriceLand</a>
        </li>
       
        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/subscription')}}" role="button" id="sub">
                            Subscription
                        </a>
                    </li>
                    <li class="nav-item">
          <a class="nav-link button mx-3 nav-link {{ Route::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">My Profile</a>
        </li>
                    <li class="nav-item">
          <a class="nav-link logoutUser nav-link button mx-3" aria-current="page" href="#">Logout</a>
        </li>
        @endif
        @if(auth()->user() && auth()->user()->is_subscribed == 0)
      
        <li class="nav-item">
                        <a class="nav-link" href="{{ url('/subscription')}}" role="button" id="sub">
                            Subscription
                        </a>
                    </li>
                    <li class="nav-item">
          <a class="nav-link logoutUser nav-link button mx-3" aria-current="page" href="#">Logout</a>
        </li>
                    @endif
        @if(!auth()->user())
        
        <li class="nav-item">
        <a class="nav-link {{ Request::segment(1) === 'about' ? 'active' : null }}" href="{{ url('/about')}}" id="ab">About </a>                    </li>
        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" target="_self" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">                        How it works                        </a>
                        <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('/how-it-works-houses')}}" id="hw-it-hs">  How it works for houses</a></li>
                        <li><a class="dropdown-item" href="{{ url('/how-it-works-lands')}}" id="hw-it-lnd">  How it works for lands</a></li>

                        </ul>
                       

                    <!--li class="nav-item dropdown">
                    
                    <a class="nav-link dropdown-toggle" href="{{ url('/profile')}}" target="_self" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">                            Account
                        </a>
                        <!--ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                         <li><a class="dropdown-item" href="{{ url('/register')}}" id="rg"> Register</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login2')}}" id="ln"> Login</a></li>
                        </ul-->
                    <!--/li-->
                    <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) === 'faq' ? 'active' : null }}" href="{{ url('/faq')}}" role="button" id="sp">Faq
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) === 'support' ? 'active' : null }}" href="{{ url('/support')}}" role="button" id="sp">                            Contact
                        </a>
                    </li>
      
      </ul>
      
      <ul class="navbar-nav mb-0 ms-auto">
                    <li class="nav-item" id="login_b">
                        <a class="nav-link button mx-3" href="{{ url('/register') }}"><i class="fa fa-user-plus me-1"></i>Register </a>
                    </li>
                    <li class="nav-item" id="login_b">
                        <a class="nav-link button mx-3" href="{{ url('/login') }}"><i class="fa fa-user-plus me-1"></i>Login </a>
                    </li>
                </ul>
     @endif
    </div>
  </div>
</nav>
</section>