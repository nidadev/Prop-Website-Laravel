@extends('layouts.app2')

@section('content')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">
    <ul class="mb-0 mt-4">
            <li class="d-inline-block ms-2"><a class="button_1" href="#" id="map_id"><i class="fa fa-building me-1 fs-5 align-middle"></i> Sold to For Sale Ratio Map</a></li>
          </ul>
      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
          <div class="col-md-8">
            @if(Session::has('success'))
            <p class="result">{{ Session::get('success') }}</p>
            @endif
            @if(Session::has('error'))
            <p class="incorrect">{{ Session::get('error') }}</p>
            @endif
            <form method="post" action="{{ url('research')}}">
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
                      <br><input type="submit" style="border:none" class="button run" value="Run Report">
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

        <div class="col-md-12">
          <form id="research_search_form">

            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-6">
                  <div class="center_h2lil">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingFive">
                        <button class="btn btn-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                          <i class="fa fa-check-circle me-2"></i>+</button>
                      </h2>

                    </div><!---- accordion item--->

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="center_h2r">
                    <div class="center_h2ri row">
                      <div class="col-md-4">
                        <div class="center_h2ril">
                          ................
                        </div>
                      </div>

                    </div>
                  </div>
                </div>


              </div>
            </div>
        </div><!--------- 1st col-12 test----->


        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <div class="col-md-12">
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                          Acreage (Miles)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="acr" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <ul>
                              <li> Apartment <input type="checkbox" name=""></li>
                              <li> Apartment/Hotel <input type="checkbox" name=""></li>
                              <li>Cabin <input type="checkbox" name=""></li>
                              <li>Common Area <input type="checkbox" name=""></li>
                              <li>Condominium <input type="checkbox" name=""></li>
                              <li>Condominium Project <input type="checkbox" name=""></li>
                              <li>Condotel <input type="checkbox" name=""></li>
                              <li>Cooperative <input type="checkbox" name=""></li>
                              <li>Duplex <input type="checkbox" name=""></li>
                              <li>Frat/Sorority House <input type="checkbox" name=""></li>
                              <li>Group Quarters <input type="checkbox" name=""></li>
                              <li>Health Club<input type="checkbox" name=""></li>
                              <li>High Rise Condo <input type="checkbox" name=""></li>
                            </ul>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <ul>
                              <li> Apartment <input type="checkbox" name=""></li>
                              <li> Apartment/Hotel <input type="checkbox" name=""></li>
                              <li>Cabin <input type="checkbox" name=""></li>
                              <li>Common Area <input type="checkbox" name=""></li>
                              <li>Condominium <input type="checkbox" name=""></li>
                              <li>Condominium Project <input type="checkbox" name=""></li>
                              <li>Condotel <input type="checkbox" name=""></li>
                              <li>Cooperative <input type="checkbox" name=""></li>
                              <li>Duplex <input type="checkbox" name=""></li>
                              <li>Frat/Sorority House <input type="checkbox" name=""></li>
                              <li>Group Quarters <input type="checkbox" name=""></li>
                              <li>Health Club<input type="checkbox" name=""></li>
                              <li>High Rise Condo <input type="checkbox" name=""></li>
                            </ul>
                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>

              </form>
            </div><!--------- 1st col-12 test3----->
          </div><!-- accordion -->
        </div><!-- accordion-->

      </div><!-- row-->
</section>

<section id="work_h" class="p_3">
  <div class="container-xl">
    <div class="row work_h1 text-center mb-4">
      <div class="col-md-12">
        
        <h2>Research Searches</h2>
        <hr class="line mx-auto">
        <!--Export all<input type='checkbox' id='sm' onclick="javascript:toggle('')" ; class='su' value="" name='sum[]' style='border:14px solid green;width:30px;height:30px;'>-->
      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
          <p class="error"></p>
          <div class="loader" style="display:none">
          </div>
          <p class="sm-txt" style="display:none">Wait for 5 minutes.Getting Comp Records...</p>

          <div class="work_h2i p-4 rounded_10 shadow_box text-center">
            <div id="amnt" style="display:none;">Total Amount:$<span id="total_val"></span></div>
          </div>
          <div class="center_h2lil">
            <span>
              <br><span><input type="button" id="chk" style="display:none;border:none" class="button" value="Checkout"> </span>
            </span>


          </div>
          <form>

            <table class="display" style="width:100%" id="myDataTable4">
              <thead class="bg-grey-50">
                <tr>
                  <th>Zip</th>
                  <th>Total Comps</th>
                  <th>Sale Comp</th>
                  <th>Sold Comp</th>
                  <th>State</th>
                  <th>County</th>
                  <th>AvgListPriceChange</th>
                  <th>Avg Days On Market</th>

                </tr>
              <tbody id="mytable4">
                @if(isset($price))
               <?php for ($i=0; $i<count($price); $i++) {                
                    $zp = isset($price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['Zip9']) ?  $price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['Zip9']: 0;
                  $st = isset($price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['State']) ?  $price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['State']: 0;
                  $ct = isset($price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['County']) ? $price[$i]['Reports'][0]['Data']['SubjectProperty']['SitusAddress']['County']: 0;
                  $sold_home = isset($price[$i]['Reports'][0]['Data']['MarketTrendData']['SalesDetails']) ? $price[$i]['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['SoldHomes']: 0;
                  $sale_home = isset($price[$i]['Reports'][0]['Data']['MarketTrendData']['ListingDetails']) ? $price[$i]['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['HomesForSale'] : 0;
                  $avg_days  = isset($price[$i]['Reports'][0]['Data']['MarketTrendData']['ListingDetails']) ? $price[$i]['Reports'][0]['Data']['MarketTrendData']['ListingDetails']['AvgDaysOnMarket'] : 0;
                    $total_comp = $sold_home + $sale_home;
                    $avg_price  = isset($price[$i]['Reports'][0]['Data']['MarketTrendData']['SalesDetails']) ? $price[$i]['Reports'][0]['Data']['MarketTrendData']['SalesDetails']['AvgSoldPriceChange'] : 0 ;
  ?>
                  <tr>
                    <td>{{ $zp }}</td>
                    <td> {{ $total_comp }}</td>
                    <td>{{ $sale_home }}</td>
                    <td>{{ $sold_home }}</td>
                    <td>{{ $st }}</td>
                    <td>{{ $ct }}</td>
                    <td>{{ $avg_price }}</td>
                    <td>{{ $avg_days}}</td>
                  
                  </tr>
                <?php } ?>
                @endif
              </tbody>
              
            </table>
            <div class="tabmap work_h2i p-4 rounded_10 shadow_box text-center">
      <div class='tableauPlaceholder' id='viz1728542326423' style='position: relative'><noscript><a href='#'><img alt='Market Research ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Ma&#47;MarketResearch_17207118833230&#47;Sheet1&#47;1_rss.png' style='border: none' /></a></noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='' /><param name='name' value='MarketResearch_17207118833230&#47;Sheet1' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;Ma&#47;MarketResearch_17207118833230&#47;Sheet1&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1728542326423');                    var vizElement = divElement.getElementsByTagName('object')[0];                    vizElement.style.width='100%';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';                    var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>
        </div>
            <a href="#">Download Table</a>
        </div>
      </div>

</section>

@endsection