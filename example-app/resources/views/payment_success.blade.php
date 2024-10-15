@extends('layouts.app2')
@section('content')
<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">

      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
          <div class="col-md-8">
          
              <div class="center_h2l">
                <div class="center_h2li row">
                  <div class="col-md-4">
                    <div class="center_h2lil">

                    <h4>Hi {{ auth()->user()->name }}</h4> Your payment is successfully done.You can download records<br>

                    <form method="get" action="{{ url('/export_price/['.$data.']') }}" id="profile_form">
                    @csrf
                    <input type="submit" class="button dn" value="Export Records">
</form>
    <!--button class="button run" style="border:none;"><a href="{{ url('/export_price/['.$data.']')}}" style="color:#fff;text-decoration:none;">Export Records</a></button-->
   
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="center_h2lil">
                    @if(isset($pdf_check))
                    <br><br><br><br>
                    <form method="get" action="{{ url('/pdf/'.$data.'') }}" id="profile_form">
                    @csrf
                    <input type="submit" class="button dn" value="Download PDF">
</form>
                    <!--button class="button btn-pdf" style="border:none;color:#fff !important;text-decoration:none;"><a href="{{ url('/pdf/'.$data.'') }}" class="dn">Download PDF</a></button-->
                          </div>
                  </div>

                </div>
              </div>
          </div>
          <div class="col-md-4">
            <div class="center_h2r">
              <div class="center_h2ri row">
                <div class="col-md-4">
                  <div class="center_h2ril">
                  <br><br><br><br>
                  
                  <form method="get" action="{{ url('/download/xml/'.$data.'') }}" id="profile_form">
                    @csrf
                    <input type="submit" class="button dn" value="KML">
</form>
<!--button class="button btn-pdf" style="border:none;color:#fff !important;text-decoration:none;"><a href="{{ url('/download/xml/'.$data.'')}}" class="dn">Kml</a></button-->
                  @endif         
                  <div class="loader" style="display:none">
          </div>
          <p class="sm-txt" style="display:none">Wait for a minutes.Getting Export Records...</p>

                  </div>
                </div>

                <div class="col-md-4">
                  <div class="center_h2rir">

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><!-- row-->
</section>
   
@endsection
<style>
    .dn 
    {
        color:#fff !important;
        text-decoration:none !important;
    }
    .btn-pdf{
        margin-top:12px !important;
    }
    </style>

