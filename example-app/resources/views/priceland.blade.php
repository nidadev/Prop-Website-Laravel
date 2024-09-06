@extends('layouts.layout')

@section('content')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">

      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="col-md-8">
        @if(Session::has('success'))
        <p class="result">{{ Session::get('success') }}</p>

        @endif
        @if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
          <form id="priceland_search_form" method="post" action="{{ url('priceland')}}">
@csrf
            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-4">
                  <div class="center_h2lil">
                  <!--label for="autocomplete">State:</label-->
        <!--input class="form-control w-70 bg-light" id="autocomplete" name="state" type="text"-->
        <select id="st" name="state" class="form-select" aria-label="Default select example">
                      <option value="1">State Name</option>
                      <option value="1" aria-selected="true">Alabama</option>
                      <option value="2" aria-selected="false">Alaska</option>
                      <option value="4" aria-selected="false">Arizona</option>
                      <option value="5" aria-selected="false">Arkansas</option>
                      <option value="6" aria-selected="false">California</option>
                      <option value="8" aria-selected="false">Colorado</option>
                      <option value="9" aria-selected="false">Connecticut</option>
                      <option value="10" aria-selected="false">Delaware</option>
                      <option value="11" aria-selected="false">District of Columbia</option>
                      <option value="12" aria-selected="false">Florida</option>
                      <option value="13" aria-selected="false">Georgia</option>
                      <option value="14" aria-selected="false">Guam</option>
                      <option value="15" aria-selected="false">Hawaii</option>
                      <option value="16" aria-selected="false">Idaho</option>
                      <option value="17" aria-selected="false">Illinois</option>
                      <option value="18" aria-selected="false">Indiana</option>
                      <option value="19" aria-selected="false">Iowa</option>
                      <option value="20" aria-selected="false">Kansas</option>
                      <option value="21" aria-selected="false">Kentucky</option>
                      <option value="22" aria-selected="false">Louisiana</option>
                      <option value="23" aria-selected="false">Maine</option>
                      <option value="24" aria-selected="false">Maryland</option>
                      <option value="25" aria-selected="false">Massachusetts</option>
                      <option value="26" aria-selected="false">Michigan</option>
                      <option value="27" aria-selected="false">Minnesota</option>
                      <option value="28" aria-selected="false">Mississippi</option>

                      <option value="29" aria-selected="false">Missouri</option>
                      <option value="30" aria-selected="false">Montana</option>
                      <option value="31" aria-selected="false">Nebraska</option>
                      <option value="32" aria-selected="false">Nevada</option>
                      <option value="33" aria-selected="false">New Hampshire</option>
                      <option value="34" aria-selected="false">New Jersey</option>
                      <option value="35" aria-selected="false">New Mexico</option>
                      <option value="36" aria-selected="false">New York</option>
                      <option value="37" aria-selected="false">North Carolina</option>
                      <option value="38" aria-selected="false">North Dakota</option>
                      <option value="39" aria-selected="false">Ohio</option>
                      <option value="40" aria-selected="false">Oklahoma</option>
                      <option value="41" aria-selected="false">Oregon</option>
                      <option value="42" aria-selected="false">Pennsylvania</option>
                      <option value="43" aria-selected="false">Puerto Rico</option>
                      <option value="44" aria-selected="false">Rhode Island</option>
                      <option value="45" aria-selected="false">South Carolina</option>
                      <option value="46" aria-selected="false">South Dakota</option>
                      <option value="47" aria-selected="false">Tennessee</option>
                      <option value="48" aria-selected="false">Texas</option>
                      <option value="49" aria-selected="false">Utah</option>
                      <option value="50" aria-selected="false">Vermont</option>
                      <option value="51" aria-selected="false">Virgin Islands</option>
                      <option value="52" aria-selected="false">Virginia</option>
                      <option value="53" aria-selected="false">Washington</option>
                      <option value="54" aria-selected="false">West Virginia</option>
                      <option value="55" aria-selected="false">Wisconsin</option>
                      <option value="56" aria-selected="false">Wyoming</option>
                    </select>                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                  <!--label for="autocomplete">County:</label><select id="counties" name="cp" class="form-select border-0 rounded_10 bg-light"></select-->
                  <select id="cp" name="cp" class="form-select">
                      <option value="6001">Alameda</option>
                      <option value="6003">Alpine</option>
                      <option value="6005">Amador</option>
                      <option value="6007">Butte</option>
                      <option value="6009">Calaveras</option>
                      <option value="6011">Colusa</option>
                      <option value="6013">Contra Costa</option>
                      <option value="6015">Del Norte</option>
                      <option value="6017">El Dorado</option>
                      <option value="6019">Fresno</option>
                      <option value="6021">Glenn</option>
                      <option value="6023">Humboldt</option>
                      <option value="6025">Imperial</option>
                      <option value="6027">Inyo</option>
                      <option value="6029">Kern</option>
                      <option value="6031">Kings</option>
                      <option value="6033">Lake</option>
                      <option value="6035">Lassen</option>
                      <option value="6037">Los Angeles</option>
                      <option value="6041">Marin</option>
                      <option value="6043">Mariposa</option>
                      <option value="6045">Mendocino</option>
                      <option value="6047">Merced</option>
                      <option value="6049">Modoc</option>
                      <option value="6051">Mono</option>
                      <option value="6053">Monterey</option>
                      <option value="6055">Napa</option>
                      <option value="6057">Nevada</option>
                      <option value="6059">Orange</option>
                      <option value="6043">Mariposa</option>
                      <option value="6043">Mariposa</option>
                      <option value="6043">Mariposa</option>
                      <option value="043">Mariposa</option>
                      <!--------alabama-->
                      <option value="1001">Autauga County</option>
                      <option value="1003">Baldwin County</option>
                      <option value="1005">Barbour County</option>
                      <option value="1007">Bibb County</option>
                      <option value="1009">Blount County</option>
                      <option value="1011">Bullock County</option>
                      <option value="1013">Butler County</option>
                      <option value="1015">Calhoun County</option>
                      <option value="1017">Chambers County</option>
                      <option value="1019">Cherokee County</option>
                      <option value="1021">Chilton County</option>
                      <option value="1023">Choctaw County</option>
                      <option value="1025">Clarke County</option>
                      <option value="1027">Clay County</option>
                      <option value="1029">Cleburne County</option>
                      <option value="1031">Coosa County</option>
                      <option value="1033">Covington County</option>
                      <option value="1035">Crenshaw County</option>
                      <option value="1037">Cullman County</option>
                      <option value="1039">Dale County</option>
                      <option value="1041">Dallas County</option>
                      <option value="1043">DeKalb County</option>
                      <option value="1045">Elmore County</option>
                      <option value="1047">Escambia County</option>
                      <option value="1049">Etowah County</option>
                      <option value="1051">Fayette County</option>
                      <option value="1053">Franklin County</option>
                      <option value="1055">Geneva County</option>
                      <option value="1057">Greene County</option>
                      <option value="1059">Hale County</option>
                      <option value="1061">Henry County</option>
                      <option value="1063">Houston County</option>
                      <option value="1065">Jackson County</option>
                      <option value="1067">Jefferson County</option>
                      <option value="1069">Lamar County</option>
                      <option value="1071">Lauderdale County</option>
                      <option value="1073">Lawrence County</option>
                      <option value="1075">Lee County</option>
                      <option value="1077">Limestone County</option>
                      <option value="1079">Lowndes County</option>
                      <option value="1081">Madison County</option>
                      <option value="1083">Marengo County</option>
                      <option value="1085">Marion County</option>
                      <option value="1087">Marshall County</option>
                      <option value="1089">Mobile County</option>
                      <option value="1091">Monroe County</option>
                      <option value="1093">Montgomery County</option>
                      <option value="1095">Morgan County</option>
                      <option value="1097">Perry County</option>
                      <option value="1099">Pickens County</option>
                      <option value="1101">Pike County</option>
                      <option value="1103">Randolph County</option>
                      <option value="1105">Russell County</option>
                      <option value="1107">St. Clair County</option>
                      <option value="1109">Sumter County</option>
                      <option value="1111">Talladega County</option>
                      <option value="1113">Tallapoosa County</option>
                      <option value="1115">Walker County</option>
                      <option value="1117">Washington County</option>
                      <option value="1119">Wilcox County</option>
                      <option value="1121">Winston County</option>
                      <!----------------alaska------>
                      <option value="2013">Aleutians East Borough</option>
                      <option value="2016">Aleutians West Census Area</option>
                      <option value="2020">Anchorage</option>
                      <option value="2050">Bethel Census Area</option>
                      <option value="2060">Bristol Bay Borough</option>
                      <option value="2068">Denali Borough</option>
                      <option value="2070">Dillingham Census Area</option>
                      <option value="2090">Fairbanks North Star Borough</option>
                      <option value="2100">Haines Borough</option>
                      <option value="2110">Hoonah-Angoon Census Area</option>
                      <option value="2122">Juneau</option>
                      <option value="2130">Kenai Peninsula Borough</option>
                      <option value="2150">Ketchikan Gateway Borough</option>
                      <option value="2158">Kodiak Island Borough</option>
                      <option value="2164">Lake and Peninsula Borough</option>
                      <option value="2170">Matanuska-Susitna Borough</option>
                      <option value="2180">North Slope Borough</option>
                      <option value="2185">Northwest Arctic Borough</option>
                      <option value="2188">Petersburg Census Area</option>
                      <option value="2190">Prince of Wales-Hyder Census Area</option>
                      <option value="2201">Sitka</option>
                      <option value="2220">Skagway</option>
                      <option value="2230">Wrangell</option>
                      <option value="2240">Yakutat</option>
                      <option value="2261">Yukon-Koyukuk Census Area</option>
                      <!---alaska-->
                      <option value="4001">Apache County</option>
                      <option value="4003">Cochise County</option>
                      <option value="4005">Coconino County</option>
                      <option value="4007">Gila County</option>
                      <option value="4009">Graham County</option>
                      <option value="4011">Greenlee County</option>
                      <option value="4012">La Paz County</option>
                      <option value="4013">Maricopa County</option>
                      <option value="4015">Mohave County</option>
                      <option value="4017">Navajo County</option>
                      <option value="4019">Pima County</option>
                      <option value="4021">Pinal County</option>
                      <option value="4023">Santa Cruz County</option>
                      <option value="4025">Yavapai County</option>
                      <option value="4027">Yuma County</option>
                      <!-----arkansas-->
                      <option value="05001">Arkansas County</option>
                      <option value="05003">Ashley County</option>
                      <option value="05005">Baxter County</option>
                      <option value="05007">Bayou County</option>
                      <option value="05009">Benton County</option>
                      <option value="05011">Boone County</option>
                      <option value="05013">Bradley County</option>
                      <option value="05015">Calhoun County</option>
                      <option value="05017">Carroll County</option>
                      <option value="05019">Chicot County</option>
                      <option value="05021">Clark County</option>
                      <option value="05023">Clay County</option>
                      <option value="05025">Cleburne County</option>
                      <option value="05027">Cleveland County</option>
                      <option value="05029">Columbia County</option>
                      <option value="05031">Conway County</option>
                      <option value="05033">Craighead County</option>
                      <option value="05035">Crawford County</option>
                      <option value="05037">Cross County</option>
                      <option value="05039">Dallas County</option>
                      <option value="05041">Desha County</option>
                      <option value="05043">Drew County</option>
                      <option value="05045">Faulkner County</option>
                      <option value="05047">Franklin County</option>
                      <option value="05049">Fulton County</option>
                      <option value="05051">Garland County</option>
                      <option value="05053">Grant County</option>
                      <option value="05055">Greene County</option>
                      <option value="05057">Hempstead County</option>
                      <option value="05059">Hot Spring County</option>
                      <option value="05061">Howard County</option>
                      <option value="05063">Independence County</option>
                      <option value="05065">Izard County</option>
                      <option value="05067">Jackson County</option>
                      <option value="05069">Jefferson County</option>
                      <option value="05071">Johnson County</option>
                      <option value="05073">Lafayette County</option>
                      <option value="05075">Lawrence County</option>
                      <option value="05077">Lee County</option>
                      <option value="05079">Lincoln County</option>
                      <option value="05081">Little River County</option>
                      <option value="05083">Logan County</option>
                      <option value="05085">Lonoke County</option>
                      <option value="05087">Madison County</option>
                      <option value="05089">Marion County</option>
                      <option value="05091">Miller County</option>
                      <option value="05093">Mississippi County</option>
                      <option value="05095">Monroe County</option>
                      <option value="05097">Montgomery County</option>
                      <option value="05099">Nevada County</option>
                      <option value="05101">Newton County</option>
                      <option value="05103">Ouachita County</option>
                      <option value="05105">Perry County</option>
                      <option value="05107">Phillips County</option>
                      <option value="05109">Pike County</option>
                      <option value="05111">Pope County</option>
                      <option value="05113">Prairie County</option>
                      <option value="05115">Pulaski County</option>
                      <option value="05117">Randolph County</option>
                      <option value="05119">St. Francis County</option>
                      <option value="05121">Saline County</option>
                      <option value="05123">Scott County</option>
                      <option value="05125">Searcy County</option>
                      <option value="05127">Sebastian County</option>
                      <option value="05129">Sevier County</option>
                      <option value="05131">Sharp County</option>
                      <option value="05133">Stone County</option>
                      <option value="05135">Union County</option>
                      <option value="05137">Van Buren County</option>
                      <option value="05139">Washington County</option>
                      <option value="05141">White County</option>
                      <option value="05143">Woodruff County</option>
                      <option value="05145">Yell County</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                  <span>
                          Acreage (Miles)</span><input class="form-control w-50 bg-light" id="acr1" name="acr1" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        <input class="form-control w-50 bg-light" id="acr2" name="acr2" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
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
                  <br><span><input type="submit" style="border:none" class="button" value="Run Report"> </span>

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
          <form id="pricehouse_search_form">

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
        <h2>Price Land Searches</h2>
        <hr class="line mx-auto">
<h3>Total Comps: {{ isset($maxcount) ? $maxcount : '' }}</h3>
Export all<input type='checkbox' id='sm' onclick="javascript:toggle('{{ $maxcount }}')"; class='su' value="{{ $mainval_to_cp }}" name='sum[]' style='border:14px solid green;width:30px;height:30px;'>

      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
          <p class="error"></p>
          <div class="loader" style="display:none"></div>
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
                  <th>Acres</th>
                  <th>City</th>
                  <th>State</th>
                  <th>County</th>
                  <th>Sale Price Range</th>
                  <th>Export Records</th>

                </tr>
              <tbody id="mytable4">
                <?php //dd($data);?>
                @if(isset($loop))
@foreach($loop as $d)
              <tr>
                <td>{{ $acr_range }}</td>
                <td>{{ $d['City'] }}</td>
                
                <td>{{ $d['State'] }}</td>
                <td>{{ $d['County'] }}</td>
                <td>${{ $sale_price }}</td>
                <td><input type='checkbox' id='sm' onclick="javascript:toggle('{{ $maxcount }}')"; class='su' value="{{ $mainval }}" name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td>


              </tr>
              @endforeach
              @endif
              </tbody>
            </table>
            <a href="#">Download Table</a>
        </div>
      </div>

</section>

@endsection

