<section id="header"><nav class="navbar navbar-expand-lg bg-body-tertiary" aria-label="Main navigation"><div class="container-fluid">
<a class="text-black p-0 navbar-brand fw-bold logo_position_rel" href="{{ url('/home') }}"><img src="{{ asset('img/logo2.png') }}" width="245" height="38" class="img-fluid" alt="Propelyze"></a>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
<div class="collapse navbar-collapse" id="navbarSupportedContent"><ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
@php
$navigationGroups = [
    'Explore' => ['/priceland'=>'Search Land', '/pricehouse'=>'Search Houses', '/research'=>'Market Research', '/land-valuation'=>'Land Valuation', '/land-comps'=>'Land Comparables', '/compreport'=>'Comp Reports', '/list-upload'=>'Upload a List'],
    'How it works' => ['/how-it-works-lands'=>'For Land', '/how-it-works-houses'=>'For Houses'],
    'Resources' => ['/about'=>'About Us', '/subscription-home'=>'Pricing & Subscriptions', '/api-information'=>'API', '/bulk-data'=>'Bulk Data Purchase', '/investor-marketplace'=>'Investor Marketplace', '/faq'=>'Frequently Asked Questions', '/support'=>'Contact & Support', '/terms'=>'Terms & Conditions'],
];
@endphp
@foreach($navigationGroups as $group => $links)
<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="siteMenu{{ $loop->index }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $group }}</a><ul class="dropdown-menu drop_1" aria-labelledby="siteMenu{{ $loop->index }}">
@foreach($links as $path => $label)<li><a class="dropdown-item" href="{{ url($path) }}">{{ $label }}@if(in_array($path, ['/priceland','/pricehouse','/compreport']) && !config('property.datatree_enabled', true)) <small class="d-block text-muted">Temporarily unavailable</small>@endif</a></li>@endforeach
</ul></li>
@endforeach
<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="accountNavigation" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ auth()->check() ? 'My Account' : 'Account' }}</a><ul class="dropdown-menu drop_1 dropdown-menu-lg-end" aria-labelledby="accountNavigation">
@auth
@foreach(['/dashboard'=>'Dashboard', '/profile'=>'My Profile', '/subscription'=>'Billing & Subscription', '/credits'=>'Account Credits', '/saved-searches'=>'Saved Searches', '/exports'=>'Export History'] as $path => $label)<li><a class="dropdown-item" href="{{ url($path) }}">{{ $label }}</a></li>@endforeach
@if(auth()->user()->usertype === 'admin')<li><hr class="dropdown-divider"></li><li><a class="dropdown-item" href="{{ url('/adminpage') }}">Administration</a></li><li><a class="dropdown-item" href="{{ url('/getproperty') }}">Property Data Tool</a></li><li><a class="dropdown-item" href="{{ url('/getproperty2') }}">Property Data Tool 2</a></li>@endif
<li><hr class="dropdown-divider"></li><li><form method="post" action="{{ url('/logout') }}">@csrf<button class="dropdown-item" type="submit">Logout</button></form></li>
@else
<li><a class="dropdown-item" href="{{ url('/login') }}">Login</a></li><li><a class="dropdown-item" href="{{ url('/register') }}">Register</a></li><li><a class="dropdown-item" href="{{ url('/forget') }}">Forgot Password</a></li>
@endauth
</ul></li></ul>
@guest<ul class="navbar-nav mb-0 ms-auto"><li class="nav-item"><a class="nav-link button mx-3" href="{{ url('/register') }}"><i class="fa fa-user-plus me-1"></i>Register</a></li><li class="nav-item"><a class="nav-link button mx-3" href="{{ url('/login') }}"><i class="fa fa-user-plus me-1"></i>Login</a></li></ul>@endguest
</div></div></nav></section>
