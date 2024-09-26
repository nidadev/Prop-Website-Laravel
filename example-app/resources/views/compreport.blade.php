@extends('layouts.layout')

@section('content')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">
      <div class="row center_h1">
        <div class="col-md-12">
          <ul class="mb-0 mt-4">
            <li class="d-inline-block"><button class="button" style="border:none;" id="map_id">Coverage Map </button></li>
            <li class="d-inline-block"><a class="button_1" href="#"><i class="fa fa-home me-1 align-middle fs-5"></i> Parcels on Market Map </a></li>

            <li class="d-inline-block ms-2"><a class="button_1" href="#"><i class="fa fa-building me-1 fs-5 align-middle"></i> Sold to For Sale Ratio Map</a></li>
          </ul>
        </div>
      </div>
      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="col-md-8">
          @if(Session::has('success'))
          <p class="result">{{ Session::get('success') }}</p>

          @endif
          @if(Session::has('error'))
          <p class="incorrect">{{ Session::get('error') }}</p>

          @endif
          <form id="compreport_search_form" method="post" action="{{ url('compreport')}}">
            @csrf
            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-4">
                  <div class="center_h2lil">

                    <label for="autocomplete">State:</label>
                    <input class="form-control" id="autocomplete" name="state" type="text">

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <label for="autocomplete">County:</label><select id="counties" name="cp" class="form-select"></select>

                  </div>
                </div>
                <input type="hidden" name="county_name" id="county_name">
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <label>APN </label><input type="text" class="form-control" name="apn" id="apn" placeholder="7056-010-019">
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
                  <br><input type="submit" style="border:none" class="button run" value="Run Report">
                  </form>
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
    </div>
  </div>
</section>

<section id="work_h" class="p_3">
  <div class="container-xl">
    <div class="row work_h1 text-center mb-4">
      <div class="col-md-12">
        <h2>Sale Comp Report</h2>
        <hr class="line mx-auto">
        <p class="error"></p>
        <div class="loader" style="display:none"></div>
        <p class="sm-txt" style="display:none">Wait for 5 minutes.Getting Comp Records...</p>

        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
        @if(isset($price))

          Total Amount:<span id="total_val"></span>
          <span class="pec"></span>

        </div>

      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
          <div id="amnt" style="display:none;"><span id="total_val"></span>
        <button type="button" class="button" style="border:none;"><a href="{{ url('/export/'.$poperty_id.'')}}" style="color:#fff !important;">Export</a></button></div>
          <div class="center_h2lil">
            <span>
              <br><span><input type="button" id="chk" style="display:none;border:none" class="button" value="Checkout"> </span>
            </span>


          </div>
          <form method="post" action="{{ url('/pdf') }}" id="pdf_id">

            <input type="hidden" name="pd" id="pd" class="pid" value="">
            <table class="display" style="width:100%" id="myDataTable4">
              <thead class="bg-grey-50">
                <tr>Total Property Listing
                  <!--th>Property Id</th-->
                  <td>Street Address</td>
                  <td>City</td>
                  <td>State</td>
                  <td>Owner Name</td>
                  <td>Zoning</td>
                  <td>CountyUse</td>
                  <td>Acres</td>
                  <td>Accessed Value</td>
                  <td>Export</td>
                  <!--td>Download Export</td-->
                  <td>Pdf</td>
                  <td>Kml</td>
                </tr>
              <tbody id="mytable4">
                
                <?php //dd($price); 
                ?>
                <tr>
                  <td>{{ $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['StreetAddress'] }}</td>
                  <td>{{ $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['City'] }}</td>

                  <td>{{ $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['State'] }}</td>
                  <td>{{ $price['Reports'][0]['Data']['OwnerInformation']['Owner1FullName'] }}</td>
                  <td>{{ $price['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['Zoning'] }}</td>
                  <td>{{ $price['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['County'] }}</td>
                  <td>{{ $price['Reports'][0]['Data']['PropertyDetailData']['SiteInformation']['Acres'] }}</td>
                  <td>${{ $price['Reports'][0]['Data']['TaxStatusData']['Taxes']['AssessedValue']}}</td>
                  <td><input type='checkbox' id='sm' onclick="javascript:toggle('{{ $maxcount }}')" ; class='su' value="{{ $mainval }}" name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>
                  <!--td><a href="{{ url('/export/'.$poperty_id.'')}}">Export Excel</a></td-->

                  <td><a href="{{ url('/pdf/'.$poperty_id.'') }}" class="">Download</a></td>
                  <td><a href="{{ url('/download/xml/'.$poperty_id.'')}}">Kml File</a></td>
                </tr>
                @endif
              </tbody>
            </table>
          </form>
        </div>
      </div>
</section>
@endsection
<style>
  .error {
    color: red;

  }
</style>
</body>

</html>