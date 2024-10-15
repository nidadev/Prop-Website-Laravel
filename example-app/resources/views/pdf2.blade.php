<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: lighter;
            /* Thin weight */
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #fff;
            /* Dark Blue */
            color: #000;
            padding: 20px;
            text-align: center;
            position: relative;
            margin-bottom: 20px;
        }

        header img {
            width: 147px;
            height: auto;
            display: inline-block;
        }

        h5 {
            margin: 10px 0;
            font-size: 12px;
            text-transform: uppercase;
        }

        h6 {
            margin-top: 30px;
            color: #003366;
            border-bottom: 2px solid #ff6600;
            /* Orange */
            padding-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            border: 1px solid #ccc;
            text-align: left;
            padding: 12px;
            font-size: 12px;
            font-weight: normal;
        }

        th {
            background-color: #003366;
            /* Dark Blue */
            color: #fff;
            font-weight: normal;
            /* Bold for headers */
            font-family: "Poppins";
        }

        td {
            background-color: #fff;
            color: #333;
            transition: background-color 0.3s;
        }

        td:hover {
            background-color: #f0f0f0;
        }

        .main td {
            padding: 20px;
        }

        .sale_com {
            background-color: #ff6600;
            /* Orange */
            color: #fff;
        }

        .sold_com {
            background-color: #ffc107;
            /* Gray */
            color: #fff;
        }

        section {
            padding: 15px;
            border-radius: 5px;
            margin: 10px;
            flex: 1;
            /* Make sections equal width */
        }

        p {
            font-size: 12px;
            font-family: "Poppins";
            font-weight: normal;

        }

        .property-details {
            background-color: #66ccff;
            /* Light Blue */
        }

        .public-records {
            background-color: #ffcc99;
            /* Light Orange */
        }

        .location-details {
            background-color: #ff9900;
            /* Bright Orange */
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            /* Space out the boxes */
            margin: 20px 0;
        }
    </style>
</head>

<body>
<img src="{{ $logo }}" alt="Company Logo"> <!-- Replace with actual logo URL -->

    <!--header>
    </header-->
    <div>       
    <img src="{{ $image }}" width="150" height="150" alt="Property Image"></td> <!-- Replace with actual image URL -->
    </div>
    <h6>Comps Overview</h6>
    <table>
        <tr>
            <th>State</th>
            <th>County</th>
            <th>Apn</th>
            <th>Lot Acreage</th>
            <th>Owner First Name</th>
            <th>Owner Last Name</th>
            <th>Owner Mailing Address</th>
        </tr>
        <tr>
            <td>{{ $state }}</td>
            <td>{{ $county }}</td>
            <td> {{ $apn }}</td>
            <td>{{ $avr_acr }}</td>
            <td> {{ $owner_f }}</td>
            <td> {{ $owner_l }}</td>
            <td>{{ $mailing }}</td>

        </tr>

    </table>
    <div class="flex-container">
        <section class="property-details">
            <h5>Property Details</h5>
            <p>Address: {{ $address }}<br>
                City: {{ $city }}<br>
                Zip Code: {{ $zip }}<br>
                Subdivision: {{ $sub_d }}<br>
                Zoning:<br>
                Year Built:<br>
                Alternate APN:<br></p>
        </section>
        <section class="public-records">
            <h5>Public Records</h5>
            <p>Assessed Total Value: ${{ $assesd_val }}<br>
                Assessed Market Value: ${{ $mar_v }}<br>
                Prior Sale Date: {{ $sal_d}}<br>
                Prior Sale Mortgage:<br>
                DataTree Estimated Value:<br>
                Annual Tax:<br></p>
        </section>
        <section class="location-details">
            <h5>Location Details</h5>
            <p>Latitude: {{ $lat }}<br>
                Longitude: {{ $long }}<br>
                Land Use: {{ $land_u }}<br>
                Land Type:<br>
                County Land Use:<br>
                Legal Description:<br></p>
        </section>
    </div>

    <h6>Pricing Analysis Breakdown</h6>
    <table>
        <tr>
            <td>
                <section class="property-details">
                    <h5>Pricing Analysis</h5>
                    <table>
                        <tr>
                            <th>Pricing Source</th>
                            <th>Market Price</th>
                            <th>Market Price/Acre</th>
                        </tr>
                        <tr>
                            <td>{{ $county }} County Price </td>
                            <td> ${{ $county_av }}</td>
                            <td> ${{ $market_av }}</td>
                        </tr>
                        <tr>
                            <td>{{ $city }} City Price </td>
                            <td> ${{ $mar_pr}}</td>
                            <td>${{$city_market_av}}</td>
                        </tr>

                        <tr>
                            <td>Average Price </td>
                            <td> ${{ $average_price_river}}</td>
                            <td>${{ $avg_price_river_market_av}}</td>
                        </tr>
                        <tr>
                            <td>Geo Adjusted Price </td>
                            <td> ${{ $geo_adjusted }}</td>
                            <td> $ {{ $geo_adjusted_market_av }}</td>
                        </tr>
                    </table>
                </section>
            </td>
        </tr>
    </table>

    <h6>Comps Overview</h6>
    <table>
        <tr>
            <th>Comp Type</th>
            <th>Count</th>
            <th>Avg/Acre</th>
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
            <td> {{ $dis_zill }}</td>
        </tr>
        @endif
        <tr>
            <td> Realtor </td>
            <td> {{ $realto_s }}</td>
            <td>${{ $av_pr_ac_real }}</td>
            <td> ${{ $avg_pr_realtor }}</td>
            <td>{{ $avg_ac }}</td>
            <td> {{ $dis_zill }} </td>
        </tr>
    </table>

    <h6>Sale Comps Overview</h6>
    <table>
        <tr>
            <th class="sale_com">Acreage</th>
            <th class="sale_com">Price</th>
            <th class="sale_com">Price/Acre</th>
            <th class="sale_com">Distance</th>
            <th class="sale_com">City</th>
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
        <tr>
            <td> {{$acre_zll3}}</td>
            <td> ${{ $list_p_zll3}}</td>
            <td> {{ $zll_price_per3}} </td>
            <td> {{ $dis_zill }} miles</td>
            <td> {{$zll_cty3}}</td>
            <td> {{$zll_coun3}}</td>
            <td> <a href="https://zillow.com/homedetails/{{$href_zll3}}_zpid">Zillow</a></td>
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
            <td> {{$acre_zll3_sold}}</td>
            <td> ${{ $list_p_zll3_sold}}</td>
            <td> {{ $zll_price_per3_sold}} </td>
            <td> {{ $dis_zill }} miles</td>
            <td> {{$zll_cty3_sold}}</td>
            <td> {{$zll_coun3_sold}}</td>
            <td> <a href="https://zillow.com/homedetails/{{$href_zll3_sold}}_zpid">Zillow</a></td>
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
        <?php } ?>
    </table>
    <h6>Road Access Points</h6>

    <table>
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
            <td>${{ $city_market_av }}</td>
            <td>${{ $geo_adjusted_market_av }}</td>
            <td>{{ $sold_comp }}Parcels</td>
            <td>{{ $salecount + $total_rec + $total_red + $realto_s }} Parcels</td>
        </tr>
    </table>
</body>

</html>