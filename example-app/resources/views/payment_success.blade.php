@extends('layouts.app2')
@section('content')

<h4>Hi {{ auth()->user()->name }}</h4> Your payment is successfully done.You can download records<br>
    <button class="button run" style="border:none;"><a href="{{ url('/export_price/['.$data.']')}}" style="color:#fff;text-decoration:none;">Export Records</a></button>
    <br>
    <br>
    <div class="loader" style="display:none">
          </div>
          <p class="sm-txt" style="display:none">Wait for a minutes.Getting Export Records...</p>

@endsection

