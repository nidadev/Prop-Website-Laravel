@extends('layouts.app')

@section('main')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">

      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="col-md-12">
          <form id="pricehouse_search_form">

            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-6">
                  <div class="center_h2lil">
                    <select id="st" class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
                      <option selected>search By</option>
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
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="center_h2r">
                    <div class="center_h2ri row">
                      <div class="col-md-4">
                        <div class="center_h2ril">
                          <span><input type="submit" style="border:none" class="button" value="Run Report"> </span>

                        </div>
                      </div>

                    </div>
                  </div>
                </div>


              </div>
            </div>
        </div><!--------- 1st col-12----->

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
                      Radius Around City (Miles)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
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
        <h2>Price House Searches</h2>
        <hr class="line mx-auto">

      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
        <p class="error"></p>
        <div class="loader" style="display:none"></div>

  <table class="display" style="width:100%" id="myDataTable3">
    <thead class="bg-grey-50">
      <tr>Records
      <th>No.</th>
        <th>Property Id</th>
        <th>County</th>
        <th>City</th>
        <th>State</th>
        <th>Owner Name</th>
        <th>Address</th>
        <th>Apn</th>
        <th>Zip</th>
      </tr>
    <tbody id="mytable3">

    </tbody>
  </table>
        </div>
      </div>

</section>

@endsection
<style>
  </style>
</body>

</html>