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
                  

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about')}}" id="ab">About </a>
                    </li>
        
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" target="_self" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        How it works                        </a>
                        <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('/how-it-works-houses')}}" id="hw-it-hs">  How it works for houses</a></li>
                        <li><a class="dropdown-item" href="{{ url('/how-it-works-lands')}}" id="hw-it-lnd">  How it works for lands</a></li>
                        <li><a class="dropdown-item" href="{{ url('/faq')}}" id="fq"> Faq</a></li>

                        </ul>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/subscription')}}" role="button" id="sub">
                            Subscription
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="{{ url('/profile')}}" target="_self" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu drop_1" aria-labelledby="navbarDropdown">
                         <li><a class="dropdown-item" href="{{ url('/register')}}" id="rg"> Register</a></li>
                            <li><a class="dropdown-item" href="{{ url('/login2')}}" id="ln"> Login</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/support')}}" role="button" id="sp">
                            Contact
                        </a>
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
                        <a class="nav-link button mx-3" href="{{ url('/login2') }}"><i class="fa fa-user-plus me-1"></i>Login </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</section>

