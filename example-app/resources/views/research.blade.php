@extends('layouts.app')

@section('main')

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
          <form id="sale_search_form">

            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <label>Street Name:</label><input type="text" class="form-control" name="street_name" id="st_n" placeholder="Thornlake">

                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <label>State Name</label>

                    <select id="st" name="st" class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
                      <!--option value="1" aria-selected="true">Alabama</option>
                      <option value="Alaska" aria-selected="false">Alaska</option>
                      <option value="Arizona" aria-selected="false">Arizona</option>
                      <option value="Arkansas" aria-selected="false">Arkansas</option-->
                      <option value="6" aria-selected="false">California</option>
                      <!--option value="Colorado" aria-selected="false">Colorado</option>
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
                      <option value="Wyoming" aria-selected="false">Wyoming</option-->
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <label>Street Name:</label><input type="text" class="form-control" name="street_num" id="st_nm" placeholder="19617">
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
                  <label>County:</label><select id="cp" class="form-select">
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
                    <option value="6"></option>
                    <option value="6"></option>
                  </select>


                </div>
              </div>

              <div class="col-md-4">
                <div class="center_h2rir">
                  <span><input type="submit" style="border:none" class="button"> </span>
                  </form>
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
        <h2>Sales Comparable</h2>
        <hr class="line mx-auto">

      </div>
    </div>
    <div class="row work_h2">
      <div class="col-md-12">
        <div class="work_h2i p-4 rounded_10 shadow_box text-center">
        <p class="error"></p>

          <form>

            <table class="display" style="width:100%" id="myDataTable">
              <thead class="bg-grey-50">
                <tr>Total Data Parcel(Sales Comparable)
                  <th>Property Id</th>
                  <th>Assessed Value</th>
                  <th>County</th>
                  <th>City</th>
                  <th>State</th>
                  <th>Owner Name</th>
                  <th>Sale Price</th>
                  <th>Is for Sale</th>
                  <th>Acres</th>
                  <th>Land Use</th>
                  <th>Lot area</th>
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
</body>

</html>