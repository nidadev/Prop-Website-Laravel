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
                    <select class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
                      <option selected>search By</option>
                      <option value="1">State Name</option>
                      <option value="Alabama" aria-selected="true">Alabama</option>
                      <option value="Alaska" aria-selected="false">Alaska</option>
                      <option value="Arizona" aria-selected="false">Arizona</option>
                      <option value="Arkansas" aria-selected="false">Arkansas</option>
                      <option value="California" aria-selected="false">California</option>
                      <option value="Colorado" aria-selected="false">Colorado</option>
                      <option value="Connecticut" aria-selected="false">Connecticut</option>
                      <option value="Delaware" aria-selected="false">Delaware</option>
                      <option value="District of Columbia" aria-selected="false">District of Columbia</option>
                      <option value="Florida" aria-selected="false">Florida</option>
                      <option value="Georgia" aria-selected="false">Georgia</option>
                      <option value="Guam" aria-selected="false">Guam</option>
                      <option value="Hawaii" aria-selected="false">Hawaii</option>
                      <option value="Idaho" aria-selected="false">Idaho</option>
                      <option value="Illinois" aria-selected="false">Illinois</option>
                      <option value="Indiana" aria-selected="false">Indiana</option>
                      <option value="Iowa" aria-selected="false">Iowa</option>
                      <option value="Kansas" aria-selected="false">Kansas</option>
                      <option value="Kentucky" aria-selected="false">Kentucky</option>
                      <option value="Louisiana" aria-selected="false">Louisiana</option>
                      <option value="Maine" aria-selected="false">Maine</option>
                      <option value="Maryland" aria-selected="false">Maryland</option>
                      <option value="Massachusetts" aria-selected="false">Massachusetts</option>
                      <option value="Michigan" aria-selected="false">Michigan</option>
                      <option value="Minnesota" aria-selected="false">Minnesota</option>
                      <option value="Mississippi" aria-selected="false">Mississippi</option>

                      <option value="Missouri" aria-selected="false">Missouri</option>
                      <option value="Montana" aria-selected="false">Montana</option>
                      <option value="Nebraska" aria-selected="false">Nebraska</option>
                      <option value="Nevada" aria-selected="false">Nevada</option>
                      <option value="New Hampshire" aria-selected="false">New Hampshire</option>
                      <option value="New Jersey" aria-selected="false">New Jersey</option>
                      <option value="New Mexico" aria-selected="false">New Mexico</option>
                      <option value="New York" aria-selected="false">New York</option>
                      <option value="North Carolina" aria-selected="false">North Carolina</option>
                      <option value="North Dakota" aria-selected="false">North Dakota</option>
                      <option value="Ohio" aria-selected="false">Ohio</option>
                      <option value="Oklahoma" aria-selected="false">Oklahoma</option>
                      <option value="Oregon" aria-selected="false">Oregon</option>
                      <option value="Pennsylvania" aria-selected="false">Pennsylvania</option>
                      <option value="Puerto Rico" aria-selected="false">Puerto Rico</option>
                      <option value="Rhode Island" aria-selected="false">Rhode Island</option>
                      <option value="South Carolina" aria-selected="false">South Carolina</option>
                      <option value="South Dakota" aria-selected="false">South Dakota</option>
                      <option value="Tennessee" aria-selected="false">Tennessee</option>
                      <option value="Texas" aria-selected="false">Texas</option>
                      <option value="Utah" aria-selected="false">Utah</option>
                      <option value="Vermont" aria-selected="false">Vermont</option>
                      <option value="Virgin Islands" aria-selected="false">Virgin Islands</option>
                      <option value="Virginia" aria-selected="false">Virginia</option>
                      <option value="Washington" aria-selected="false">Washington</option>
                      <option value="West Virginia" aria-selected="false">West Virginia</option>
                      <option value="Wisconsin" aria-selected="false">Wisconsin</option>
                      <option value="Wyoming" aria-selected="false">Wyoming</option>
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
              <h3>Land characteristics</h3>
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                          Min Acreage</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Max Acreage</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Acreage Increment</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Min Market Price/Acre</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Max Market Price/Acre</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Offer Price Percent</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Min Purchase Price</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Max Purchase Price</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <h3>Land Use</h3>
                          <div class="center_h2ril">
                            <ul>
                              <li> Agricultural (Nec) <input type="checkbox" name=""></li>
                              <li> Agricultural Land <input type="checkbox" name=""></li>
                              <li>Agricultural Plant <input type="checkbox" name=""></li>
                              <li>Animal Farm <input type="checkbox" name=""></li>
                              <li>Avocado Grove <input type="checkbox" name=""></li>
                              <li>Barren Land <input type="checkbox" name=""></li>
                              <li>Citrus Grove <input type="checkbox" name=""></li>
                              <li>Commercial Acreage <input type="checkbox" name=""></li>
                              <li>Commercial Lot <input type="checkbox" name=""></li>
                              <li>Common Land <input type="checkbox" name=""></li>
                              <li>Dairy Farm <input type="checkbox" name=""></li>
                              <li>Desert<input type="checkbox" name=""></li>
                              <li>Fallow Land <input type="checkbox" name=""></li>
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
                              <li> Farms <input type="checkbox" name=""></li>
                              <li> Fish and Seed<input type="checkbox" name=""></li>
                              <li>Fisheries <input type="checkbox" name=""></li>
                              <li>Forest <input type="checkbox" name=""></li>
                              <li>Greenbelt <input type="checkbox" name=""></li>
                              <li>Livestock <input type="checkbox" name=""></li>
                              <li>Marshland <input type="checkbox" name=""></li>
                              <li>Mobile Home Lot <input type="checkbox" name=""></li>
                              <li>Mountainous Land <input type="checkbox" name=""></li>
                              <li>Multi Family Acreage <input type="checkbox" name=""></li>
                              <li>Multi Family Lot <input type="checkbox" name=""></li>
                              <li>Native American Property<input type="checkbox" name=""></li>
                              <li>Natural Resources <input type="checkbox" name=""></li>
                            </ul>
                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>

              </form>
            </div><!--------- 1st col-12 test3----->
            <div class="col-md-12">
              <h3>Owner Filters</h3>
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                          In State Owner</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          In County Owner</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Owner Occupied</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>


                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <span>
                              Corporate Owned</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Do Not Mail</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Number of Properties Owned</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <span>
                              Owner Name</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Mailing State</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Mailing Zip Code</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>

              </form>
            </div><!--------- 2nd col-12 test3----->
            <div class="col-md-12">
              <h3>Assessor Tax Filters</h3>
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                          Assessed Improvement %</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Assessed Value ($)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>



                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">

                            <span>
                              Market Land Value ($)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Market Improvement Value ($)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <span>
                              Assessed Land Value ($)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Delinquency</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>

                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>

              </form>
            </div><!--------- 3rd col-12 test3----->
            <div class="col-md-12">
              <h3>
                Property Information Filters</h3>
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                          Cities</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                        <span>
                          Zip Code</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>

                        <span>
                          Subdivision</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>

                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">

                            <span>
                              Zoning</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Census Tract</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Living Area (Sq Ft)</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <span>
                              HOA</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              Unassigned Address</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                            <span>
                              APN Range</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                            </span>
                          </div>


                        </div>
                      </div>
                    </div>



                  </div>


                </div>
            </div>

          </div><!--------- 4th col-12 test3----->
          <div class="col-md-12">
            <h3>
              Sale Information Filters</h3>
            <form id="pricehouse_search_form">

              <div class="center_h2l">
                <div class="center_h2li row">
                  <div class="col-md-4">
                    <div class="center_h2lil">
                      <span>
                        Last Sale Date</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                      </span>
                      <span>
                        Last Sale Price</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                      </span>


                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="center_h2r">
                      <div class="center_h2ri row">
                        <h3>Deed Type</h3>
                        <div class="center_h2ril">
                          <ul>
                            <li>All Deeds<input type="checkbox" name=""></li>
                            <li>General Warranty Deed<input type="checkbox" name=""></li>
                            <li>Special Warranty Deed<input type="checkbox" name=""></li>
                            <li>Quit Claim Deed <input type="checkbox" name=""></li>
                            <li>Grant Deed<input type="checkbox" name=""></li>
                            <li>Distress Sale <input type="checkbox" name=""></li>
                          </ul>


                        </div>

                      </div>
                    </div>

                  </div>
                  <div class="col-md-4">
                    <div class="center_h2r">
                      <div class="center_h2ri row">
                        <div class="center_h2ril">

                        </div>


                      </div>
                    </div>
                  </div>



                </div>


              </div>
          </div>

          <div class="col-md-12">
              <h3>Listing Information Filters
              </h3>
              <form id="pricehouse_search_form">

                <div class="center_h2l">
                  <div class="center_h2li row">
                    <div class="col-md-4">
                      <div class="center_h2lil">
                        <span>
                        Listing Status</span><input class="form-control w-50 bg-light" name="radius-around city (miles)" id="" class="has-custom-focus" type="number" placeholder="" aria-required="false" aria-invalid="false" autocomplete="off" step="0.001" min="0" value="">
                        </span>
                                             </div>
                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            
                          </div>

                        </div>
                      </div>

                    </div>
                    <div class="col-md-4">
                      <div class="center_h2r">
                        <div class="center_h2ri row">
                          <div class="center_h2ril">
                            <span>
                             
                          </div>
                        </div>
                      </div>



                    </div>


                  </div>
                </div>

              </form>
            </div><!--------- 6th col-12 test3----->
             
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
      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">

        </div>
      </div>

</section>

@endsection
<script>

</script>
</body>

</html>