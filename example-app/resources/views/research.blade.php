@extends('layouts.app')

@section('main')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">
      <div class="row center_h1">
        <div class="col-md-12 poppins-regular">
          <ul class="mb-0 mt-4">
            <li class="d-inline-block"><button class="button" style="border:none;" id="map_id">Coverage Map </button></li>
            <li class="d-inline-block"><a class="button_1" href="#"><i class="fa fa-home me-1 align-middle fs-5"></i> Parcels on Market Map </a></li>

            <li class="d-inline-block ms-2"><a class="button_1" href="#"><i class="fa fa-building me-1 fs-5 align-middle"></i> Sold to For Sale Ratio Map</a></li>
          </ul>
        </div>
      </div>
      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="col-md-12 poppins-regular">
          <form id="sale_search_form">

            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-3">
                  <div class="center_h2lil">
                    <label>State Name</label>

                    <select id="st" class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
                      <option selected>search By</option>
                      <option value="1">State Name</option>
                      <option value="1" name="" aria-selected="true">Alabama</option>
                      <option value="2" aria-selected="false">Alaska</option>
                      <option value="4" aria-selected="false">Arizona</option>
                      <option value="5" aria-selected="false">Arkansas</option>
                      <option value="6" name="" aria-selected="false">California</option>
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
                <div class="col-md-3">
                  <div class="center_h2lil">
                    <!--label>County:</label><select id="cp" class="form-select">
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
                      <option value="6043">Mariposa</option>
                    </select-->
                    Acres:0-5<input type="radio" name="sele_ac" id="ac_sel" style="border:none" class="button" value="5"><br>
                    Acres:10-20<input type="radio" name="sele_ac" id="ac_sel" style="border:none" class="button" value="10"><br>
                    Acres:20+<input type="radio" name="sele_ac" id="ac_sel" style="border:none" class="button" value="100">

                  </div>
                </div>
                <div class="col-md-3">
                  <div class="center_h2lil">
                  <span>
                  <br><span><input type="submit" style="border:none" class="button" value="Run Report"> </span>
                  </span>


                  </div>
                </div>
                <div class="col-md-3">
                  <div class="center_h2lil">
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="work_h" class="p_3">
  <div class="container-xl">
    <div class="row work_h1 text-center mb-4">
      <div class="col-md-12 poppins-regular">
        <h2>Analysis Results</h2>
        <hr class="line mx-auto">

      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12 poppins-regular">
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

            <table class="display" style="width:100%" id="myDataTable">
              <thead class="bg-grey-50">
                <tr>
                  <th>Total Comps</th>
                  <th>Acres</th>
                  <th>State</th>
                  <th>County</th>
                  <th>Sale Price Range</th>
                  <th>Export Records</th>
                 
                </tr>
              <tbody id="mytable">     
           

              </tbody>
            </table>
          </form>
        </div>
      </div>

</section>

<section id="explore" class="pt-5 pb-5 bg_white carousel_p">
  <div class="container-xl map">
    <div class='tableauPlaceholder' id='viz1722762005819' style='position: relative'><noscript><a href='#'>
          <img alt='Market Research ' src='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;C8&#47;C8TN4FWZ3&#47;1_rss.png' style='border: none' /></a>
      </noscript><object class='tableauViz' style='display:none;'>
        <param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' />
        <param name='embed_code_version' value='3' />
        <param name='path' value='shared&#47;C8TN4FWZ3' />
        <param name='toolbar' value='yes' />
        <param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;C8&#47;C8TN4FWZ3&#47;1.png' />
        <param name='animate_transition' value='yes' />
        <param name='display_static_image' value='yes' />
        <param name='display_spinner' value='yes' />
        <param name='display_overlay' value='yes' />
        <param name='display_count' value='yes' />
        <param name='language' value='en-US' />
      </object></div>
    <script type='text/javascript'>
      var divElement = document.getElementById('viz1722762005819');
      var vizElement = divElement.getElementsByTagName('object')[0];
      vizElement.style.width = '100%';
      vizElement.style.height = (divElement.offsetWidth * 0.75) + 'px';
      var scriptElement = document.createElement('script');
      scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';
      vizElement.parentNode.insertBefore(scriptElement, vizElement);
    </script>

  </div>

</section>


@endsection
<style>
  .error {
    color: red;

  }
</style>
     <!--td><span id="comps"></span>
              </td>
              <td><span id="acres"></span>
              </td>
              <td><span id="state"></span>
              </td>
              <td><span id="cunty"></span>
              </td>
              <td><span id="price"></span>
              </td>
                            <td><input type='checkbox' id='sm' class='su' value='0.01' name='sum[]' style='border:14px solid green;width:30px;height:30px;'></td-->

</body>

</html>