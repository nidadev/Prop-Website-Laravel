<!DOCTYPE html>
<html>

<head>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td,
    th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    th {
      background-color: #dddddd;
    }

    table,
    th,
    td {
      border: 1px solid #ccc;
      border-collapse: collapse;
      font-family: 'Poppins' !important;
      font-weight: normal;
      font-size: 12px;
    }

    .main td {
      padding: 20px;
    }

    .sale_com {
      background-color: #740979;
      color: #fff;
    }

    .sold_com {
      background-color: #d0c009;
      color: #fff;
    }
  </style>
</head>

<body>

  <img src="{{ $logo }}" width="147px" height="60px">
  <h4>Comp Report</h4>
  <div>
    <p>
    </p>

    <table class="poppins-regular main">
      <tr>
        <td><img src="{{ $image }}" width="250px" height="250px"></td>
        <td>State: {{ $state }}<br>
          County: {{ $county }}<br>
          Apn: {{ $apn }}<br>
          Lot Acreage:<br>
          Owner First Name: {{ $owner_f }}<br>
          Owner Last Name:{{ $owner_l }}<br>
          Owner Mailing Address: {{ $mailing }}<br>

        </td>
      </tr>

    </table>

  </div>
  <table style="width:100%">
    <tr>
      <td>
        <section style="background-color:lightgreen;color:#000;">
          <h4>Property Details</h4>
          <p>Address: {{ $address }}<br>
            City: {{ $city }}<br>
            Zip Code: {{ $zip }}<br>
            Subdivision: {{ $sub_d }}<br>
            Zoning:<br>
            Year Built:<br>
            Alternate APN:<br></p>
        </section>
      </td>
      <td>
        <section style="background-color:lightblue;color:#000;">
          <h4>Public Records</h4>
          <p>Assessed Total Value: ${{ $assesd_val }}<br>
            Assessed Market Value: ${{ $mar_v }}<br>
            Prior Sale Date: {{ $sal_d}}<br>
            Prior Sale Mortgage:<br>
            DataTree Estimated Value:<br>
            Annual Tax:<br>
            <br>
          </p>
        </section>
      </td>
      <td>
        <section style="background-color:orange;color:#000;">
          <h4>Location Details
          </h4>
          <p>Latitude: {{ $lat }}<br>
            Longitude: {{ $long }}<br>
            Land Use: {{ $land_u }}<br>
            Land Type:<br>
            County Land Use:<br>
            Legal Description:<br>
          </p>
        </section>
      </td>
    </tr>
  </table>
  <h6>Pricing Analysis Breakdown</h6>
  <table>
    <tr>
      <th>Pricing Source</th>
      <th>Market Price </th>
      <th>Market Price/Acre </th>
    </tr>
    <tr>
      <td>{{ $county }} County Price </td>
      <td> ${{ $county_av }}</td>
      <td> ${{ $market_av }}</td>
    </tr>
    <tr>
      <td>{{ $city }} City Price </td>
      <td> ${{ $mar_pr}}</td>
      <td></td>
    </tr>

    <tr>
      <td>Average Price </td>
      <td> ${{ $average_price_river}}</td>
      <td></td>
    </tr>
    <tr>
      <td>Geo Adjusted Price </td>
      <td> ${{ $geo_adjusted }}</td>
      <td></td>
    </tr>

  </table>
  <h6>Comps Overview</h6>
  <table>
    <tr>
      <th>Comp Type</th>
      <th>Count</th>
      <th>Avg/Acre </th>
      <th>Avg $</th>
      <th>Avg Acreage</th>
      <th>Avg Distance</th>
    </tr>
    <tr>
      <td> Sale</td>
      <td> {{ $salecount }}</td>
      <td> ${{ $aver_per_ac }}</td>
      <td> ${{ $avg_pr }}</td>
      <td> {{ $avr_acr }}</td>
      <td> {{ $avr_d }}</td>
    </tr>
    <tr>
      <td> Zillow </td>
      <td> {{ $total_rec }}</td>
      <td> ${{ $av_per_acre_zill }}</td>
      <td> ${{ $zillow }}</td>
      <td> {{ $zill_acre_avg }}</td>
      <td> {{ $dis_zill }}</td>
    </tr>
    @if($total_red > 0)
    <tr>
      <td> Redfin </td>
      <td> {{ $total_red }}</td>
      <td> ${{ $avg_per_acre_red}}</td>
      <td>${{ $average_red}} </td>
      <td>{{ $av_acre_red}}</td>
      <td> </td>
    </tr>
    @endif
    <tr>
      <td> Realtor </td>
      <td> {{ $realto_s }}</td>
      <td>${{ $av_pr_ac_real }}</td>
      <td> ${{ $avg_pr_realtor }}</td>
      <td>{{ $avg_ac }}</td>
      <td> </td>
    </tr>
  </table>
  <h6>Sale Comps Overview</h6>
  <table>
    <tr>
      <th class="sale_com">Acreage</th>
      <th class="sale_com">Price</th>
      <th class="sale_com">Price/Acre </th>
      <th class="sale_com">Distance</th>
      <th class="sale_com">city</th>
      <th class="sale_com">County</th>
      <th class="sale_com">Source</th>

    </tr>
    @if($acre_real > 0 )
    <tr>
      <td> {{ number_format($acre_real,1)}}</td>
      <td> ${{ $list_p_real}}</td>
      <td> {{ $real_price_per}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$real_cty}}</td>
      <td> {{$real_coun}}</td>
      <td> <a href="{{$href_real}}">Realtor</a></td>
    </tr>
    @else
    if($acre_real1 > 0)
    <tr>
      <td> {{number_format($acre_real1,1)}}</td>
      <td> ${{ $list_p_real1}}</td>
      <td> {{ $real_price_per1}} </td>
      <td> {{ $dis_zill}} miles</td>
      <td> {{$real_cty1}}</td>
      <td> {{$real_coun1}}</td>
      <td> <a href="{{$href_real1}}">Realtor</a></td>
    </tr>
    @endif
    @if($acre_red)
    <tr>
      <td> {{number_format($acre_red,1)}}</td>
      <td> ${{ $list_p_red}}</td>
      <td> {{ $red_price_per}} </td>
      <td> {{ $dis_zill }}</td>
      <td> {{$red_cty}}</td>
      <td> {{$red_coun}}</td>
      <td> <a href="https://redfin.com{{$href_redfin}}">Redfin</a></td>
    </tr>
    @endif
    <tr>
      <td> {{ $acre_zll}}</td>
      <td> ${{ $list_p_zll}}</td>
      <td> {{ $zll_price_per}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty}}</td>
      <td> {{$zll_coun}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll}}_zpid">Zillow</a></td>
    </tr>

    <tr>
      <td> {{ $acre_zll1}}</td>
      <td> ${{ $list_p_zll1}}</td>
      <td> {{ $zll_price_per1}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty1}}</td>
      <td> {{$zll_coun1}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll1}}_zpid">Zillow</a></td>
    </tr>
    <tr>
      <td> {{$acre_zll2}}</td>
      <td> ${{ $list_p_zll2}}</td>
      <td> {{ $zll_price_per2}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty2}}</td>
      <td> {{$zll_coun2}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll2}}_zpid">Zillow</a></td>
    </tr>

  </table>
  <h6>Sold Comps Overview</h6>
  <table>
    <tr>
      <th class="sold_com">Acreage</th>
      <th class="sold_com">Price</th>
      <th class="sold_com">Price/Acre </th>
      <th class="sold_com">Distance</th>
      <th class="sold_com">city</th>
      <th class="sold_com">County</th>
      <th class="sold_com">Source</th>

    </tr>
    @if($acre_red_sold)
    <tr>
      <td> {{ number_format($acre_red_sold,1)}}</td>
      <td> ${{ $list_p_red_sold}}</td>
      <td> {{ $red_price_per_sold}} </td>
      <td> {{ $dis_zill }}</td>
      <td> {{$red_cty_sold}}</td>
      <td> {{$red_coun_sold}}</td>
      <td> <a href="https://redfin.com{{$href_redfin_sold}}">Redfin</a></td>
    </tr>
    @endif
    <tr>
      <td> {{$acre_zll_sold}}</td>
      <td> ${{ $list_p_zll_sold}}</td>
      <td> {{ $zll_price_per_sold}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty_sold}}</td>
      <td> {{$zll_coun_sold}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll_sold}}_zpid">Zillow</a></td>
    </tr>
    <tr>
      <td> {{$acre_zll1_sold}}</td>
      <td> ${{ $list_p_zll1_sold}}</td>
      <td> {{ $zll_price_per1_sold}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty1_sold}}</td>
      <td> {{$zll_coun1_sold}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll1_sold}}_zpid">Zillow</a></td>
    </tr>
    <tr>
      <td> {{$acre_zll2_sold}}</td>
      <td> ${{ $list_p_zll2_sold}}</td>
      <td> {{ $zll_price_per2_sold}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$zll_cty2_sold}}</td>
      <td> {{$zll_coun2_sold}}</td>
      <td> <a href="https://zillow.com/homedetails/{{$href_zll2_sold}}_zpid">Zillow</a></td>
    </tr>
    <tr>
      <td> {{ number_format($acre_real_sold,1)}}</td>
      <td> ${{ $list_p_real_sold}}</td>
      <td> {{ $real_price_per_sold}} </td>
      <td> {{ $dis_zill }} miles</td>
      <td> {{$real_cty_sold}}</td>
      <td> {{$real_coun_sold}}</td>
      <td> <a href="{{$href_real_sold}}">Realtor</a></td>
    </tr>
  </table>
  <h6>Offer Price Appendix</h6>
  <table>
    <th>Percent of Market Value </th>
    <th>County Offer </th>

    <th>City Offer </th>
    <th>Geo Adjusted Offer Price
    </th>

    <?php

    $cal_arr = [100, 95, 90, 85, 80, 75, 70, 65, 60, 55, 50, 45, 40, 35, 30, 25, 20, 15, 10, 5, 0];
    //dd($county);
    for ($i = 0; $i < count($cal_arr) - 1; $i++) {
      $total_per_c = $county_av * $cal_arr[$i] / 100;
      $total_per_ct = $mar_pr * $cal_arr[$i];
      $total_per_geo = $geo_adjusted * $cal_arr[$i];
    ?>
      <tr>
        <td>{{ $cal_arr[$i]}}%</td>
        <td>${{ $total_per_c }}</td>
        <td>${{ $total_per_ct }}</td>

        <td>${{ $total_per_geo }}</td>

      </tr>
  <?php } ?></table>
<table>

  <h6>Road Access Points</h6>

  <tr>
    <th>Road Name </th>
    <th>Nearest Point to Property </th>
    <th>Property Access ? </th>
  </tr>
  <tr>
    <td>{{ $address }}</td>
    <td>{{ $lat }}, {{ $long }}</td>
    <td>Yes</td>
  </tr>

</table>
<h6>Subdivision Price Appendix</h6>

<table>
  <tr>
    <th>Acreage </th>
    <th>County Price/Acre </th>
    <th>City Price/Acre </th>
    <th>Geo AdjustedPrice/Acre </th>
    <th>Sold Comp Count</th>
    <th>Sale Comp Count</th>
  </tr>
  <tr>
    <td>{{ $avr_acr }}</td>
    <td>${{ $market_av }}</td>
    <td>${{ $market_av }}</td>
    <td>${{ $market_av }}</td>
    <td>{{ $sold_comp }}Parcels</td>
    <td>{{ $salecount + $total_rec + $total_red + $realto_s }} Parcels</td>
  </tr>
</table>
</body>

</html>