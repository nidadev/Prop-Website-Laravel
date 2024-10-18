<table class="display" style="width:100%" id="myDataTable4">
              <thead class="bg-grey-50">
                <tr>
                  <th>Acreage</th>
                  <!--th>Data tree Owner Records</th-->
                  <th>Data tree Owner Records</th>
                  <th>ZipCode</th>
                  <th>State</th>
                  <th>County</th>
                  <th>Median Sale Price</th>
                  <th>Avg Days On Market</th>
                  <th>Export Records</th>
                  <!--th>Export Data</th-->


                </tr>
              <tbody id="mytable4">
                <?php //dd($price);?>
                @if(isset($price))
                <?php //dd($price);
                ?>


                <?php for ($i = 0; $i < count($price); $i++) {
                  $datatree = $sts[$i]['sum'];
                  $acre = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80, 85, 90, 95, 100, 150, 200, 250, 300];

                  //$total = $datatree * $mainval;
                  //$prop = 'prop'.$i;
                  // dd($sts);

                  $maxc = $de[$i]['MaxResultsCount'];
                  $total = $maxc * $mainval;
                  //$avg_s = $price[$i]['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarket'];
                  //$avg_s  = isset($avg_s) ? $avg_s : '';
                  $avg_s = '';
                  $sl_pr = $price[$i]['Reports'][0]['Data']['LastMarketSaleInformation']['SalePrice'];
                  //$pr_per_acre = number_format($sl_pr/$acre[$i+1],2);
                  $ct = isset($de[$i]['LitePropertyList'][0]['County']) ? $de[$i]['LitePropertyList'][0]['County'] : 0;
                  $st = isset($de[$i]['LitePropertyList'][0]['State']) ? $de[$i]['LitePropertyList'][0]['State'] : 0;
                  $zp = isset($de[$i]['zipcode']) ? $de[$i]['zipcode'] : 0;
                  $exp =implode(",",$sts[$i]['prop']);

                  /*foreach ($exp as $x => $x_value) {
                    echo "Key=" . $x . ", Value=" . $x_value;
                    echo "<br>";
                  }
                  dd($x_value);*/
                  /*for($y=0; $y<count($exp); $y++)
                  {
                    $pro[] = $exp[$y];
                  }*/
                  //dd($exp);
//if payment is not complete or unpaid then export data button will be disabled
                  $avg = isset($avg_s) ? $avg_s : 0;
                  $info = ['0-5', '5-10', '10-15', '15-20', '20-25', '25-30', '30-35', '35-40', '40-45', '45-50', '50-55', '60-65', '65-70', '70-75', '75-80', '80-85', '85-90', '90-95', '95-100', '100-105', '105-110', '110-115', '115-120', '120-125']; //echo $res; 
                ?>
                  <tr>
                    <td>{{ $info[$i] }}</td>
                    <!--td>{{ $datatree }}</td-->
                    <td>{{ $maxc}}</td>
                    <td>{{ $zp}}</td>
                    <td>{{ $st}}</td>
                    <td>{{ $ct}}</td>
                    <td>${{ $sl_pr}}</td>
                    <td>{{ $avg }}</td>

                    <td><input type='checkbox' id='sm' onclick="javascript:toggle('{{ $maxc }}')" ; class='su' value="{{ $total }}" name='sum[]' data-element="{{$exp}}" style='border:14px solid green;width:30px;height:30px;'></td>
                  