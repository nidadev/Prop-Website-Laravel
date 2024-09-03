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

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

th {
  background-color: #dddddd;
}
table, th, td {
  border: 1px solid #ccc;
  border-collapse: collapse;
  font-family: 'Poppins' !important;
  font-weight:normal;
  font-size: 12px;
}
.main td {
    padding:20px;
}
</style>
</head>
<body>

<img src="{{ $logo }}" width="147px" height="60px"><h4>Comp Report</h4>
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
        <td><section style="background-color:lightgreen;color:#000;">
<h4>Property Details</h4>
<p>Address: {{ $address }}<br>
City: {{ $city }}<br>
Zip Code: {{ $zip }}<br>
Subdivision: {{ $sub_d }}<br>
Zoning:<br>
Year Built:<br>
Alternate APN:<br></p>
</section></td>
<td><section style="background-color:lightblue;color:#000;">
<h4>Public Records</h4>
<p>Assessed Total Value: {{ $assesd_val }}<br>
Assessed Market Value: {{ $mar_v }}<br>
Prior Sale Date: {{ $sal_d}}<br>
Prior Sale Mortgage:<br>
DataTree Estimated Value:<br>
Annual Tax:<br>
           <br></p>
</section></td>
<td><section style="background-color:orange;color:#000;">
<h4>Location Details
</h4>
<p>Latitude: {{ $lat }}<br>
Longitude: {{ $long }}<br>
Land Use: {{ $land_u }}<br>
Land Type:<br>
County Land Use:<br>
Legal Description:<br>
            </p></section></td>
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
    <td> {{ $zill_acre_avg }}<</td>
    <td> {{ $dis_zill }}</td>
  </tr>
  <tr> 
    <td> Redfin </td>
    <td> </td>
    <td> </td>
    <td> </td>
    <td></td>
    <td> </td>
  </tr>
  
 
  
</table>

</body>
</html>
