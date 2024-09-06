<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">Trail</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @if(auth()->user()->is_subscribed == 1)
        <li class="nav-item">
          <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Test Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('compreport') ? 'active' : '' }}" aria-current="page" href="{{ route('compreport') }}">CompReport</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('priceland') ? 'active' : '' }}" aria-current="page" href="{{ route('priceland') }}">PriceLand</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Route::is('logout') ? 'active' : '' }}" aria-current="page" href="{{ route('logout') }}">Logout</a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link {{ Route::is('subscription') ? 'active' : '' }}" aria-current="page" href="{{ route('subscription') }}">Subscription</a>
        </li>
        
      
      </ul>
     
    </div>
  </div>
</nav>