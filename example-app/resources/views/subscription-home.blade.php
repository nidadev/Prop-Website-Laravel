@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg"><div class="center_om bg_backo"><div class="container-xl"><div class="row center_o1 m-auto text-center"><div class="col-md-12"><h1 class="text-white h2">Pricing Plan</h1><h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> Pricing Plan</h6></div></div></div></div></section>
@include('partials.public-pricing')
@endsection
