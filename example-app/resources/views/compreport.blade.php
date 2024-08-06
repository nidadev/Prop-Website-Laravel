@extends('layouts.app')

@section('main')

<section id="center" class="center_h">
  <div class="center_om">
    <div class="container-xl">

      <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
        <div class="col-md-8">
          <form id="sale_search_form">

            <div class="center_h2l">
              <div class="center_h2li row">
                <div class="col-md-4">
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
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <select class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
                      <option selected>search By</option>
                      <option value="1">County Name</option>
                      <option value="Autauga County" aria-selected="true">Autauga County</option>
                      <option value="Baldwin County" aria-selected="false">Baldwin County</option>
                      <option value="Barbour County" aria-selected="false">Barbour County</option>
                      <option value="Bibb County" aria-selected="false">Bibb County</option>
                      <option value="Blount County" aria-selected="false">Blount County</option>
                      <option value="Bullock County" aria-selected="false">Bullock County</option>
                      <option value="Butler County" aria-selected="false">Butler County</option>
                      <option value="Calhoun County" aria-selected="false">Calhoun County</option>
                      <option value="Chambers County" aria-selected="false">Chambers County</option>
                      <option value="Cherokee County" aria-selected="false">Cherokee County</option>
                      <option value="Chilton County" aria-selected="false">Chilton County</option>
                      <option value="Choctaw County" aria-selected="false">Choctaw County</option>
                      <option value="Clarke County" aria-selected="false">Clarke County</option>
                      <option value="Clay County" aria-selected="false">Clay County</option>
                      <option value="Cleburne County" aria-selected="false">Cleburne County</option>
                      <option value="Coffee County" aria-selected="false">Coffee County</option>
                      <option value="Colbert County" aria-selected="false">Colbert County</option>
                      <option value="Conecuh County" aria-selected="false">Conecuh County</option>
                      <option value="Coosa County" aria-selected="false">Coosa County</option>
                      <option value="Covington County" aria-selected="false">Covington County</option>
                      <option value="Crenshaw County" aria-selected="false">Crenshaw County</option>
                      <option value="Cullman County" aria-selected="false">Cullman County</option>
                      <option value="Dale County" aria-selected="false">Dale County</option>
                      <option value="Dallas County" aria-selected="false">Dallas County</option>
                      <option value="DeKalb County" aria-selected="false">DeKalb County</option>
                      <option value="Elmore County" aria-selected="false">Elmore County</option>
                      <option value="Escambia County" aria-selected="false">Escambia County</option>
                      <option value="Etowah County" aria-selected="false">Etowah County</option>
                      <option value="Fayette County" aria-selected="false">Fayette County</option>
                      <option value="Franklin County" aria-selected="false">Franklin County</option>
                      <option value="Geneva County" aria-selected="false">Geneva County</option>
                      <option value="Greene County" aria-selected="false">Greene County</option>
                      <option value="Hale County" aria-selected="false">Hale County</option>
                      <option value="Henry County" aria-selected="false">Henry County</option>
                      <option value="Houston County" aria-selected="false">Houston County</option>
                      <option value="Jackson County" aria-selected="false">Jackson County</option>
                      <option value="Jefferson County" aria-selected="false">Jefferson County</option>
                      <option value="Lamar County" aria-selected="false">Lamar County</option>
                      <option value="Lauderdale County" aria-selected="false">Lauderdale County</option>
                      <option value="Lawrence County" aria-selected="false">Lawrence County</option>
                      <option value="Lee County" aria-selected="false">Lee County</option>
                      <option value="Limestone County" aria-selected="false">Limestone County</option>
                      <option value="Lowndes County" aria-selected="false">Lowndes County</option>
                      <option value="Macon County" aria-selected="false">Macon County</option>
                      <option value="Madison County" aria-selected="false">Madison County</option>
                      <option value="Marengo County" aria-selected="false">Marengo County</option>
                      <option value="Marion County" aria-selected="false">Marion County</option>
                      <option value="Marshall County" aria-selected="false">Marshall County</option>
                      <option value="Mobile County" aria-selected="false">Mobile County</option>
                      <option value="Monroe County" aria-selected="false">Monroe County</option>
                      <option value="Montgomery County" aria-selected="false">Montgomery County</option>
                      <option value="Morgan County" aria-selected="false">Morgan County</option>
                      <option value="Perry County" aria-selected="false">Perry County</option>
                      <option value="Pickens County" aria-selected="false">Pickens County</option>
                      <option value="Pike County" aria-selected="false">Pike County</option>
                      <option value="Randolph County" aria-selected="false">Randolph County</option>
                      <option value="Russell County" aria-selected="false">Russell County</option>
                      <option value="Shelby County" aria-selected="false">Shelby County</option>
                      <option value="St. Clair County" aria-selected="false">St. Clair County</option>
                      <option value="Sumter County" aria-selected="false">Sumter County</option>
                      <option value="Talladega County" aria-selected="false">Talladega County</option>
                      <option value="Tallapoosa County" aria-selected="false">Tallapoosa County</option>
                      <option value="Tuscaloosa County" aria-selected="false">Tuscaloosa County</option>
                      <option value="Walker County" aria-selected="false">Walker County</option>
                      <option value="Washington County" aria-selected="false">Washington County</option>
                      <option value="Wilcox County" aria-selected="false">Wilcox County</option>
                      <option value="Winston County" aria-selected="false">Winston County</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="center_h2lil">
                    <input class="form-control border-0 rounded_10 bg-light" value="APN" id="loc" name="location" placeholder="APN" type="text">

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
                  <span><input type="submit" style="border:none" class="button" value="Run Report"> </span>

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
        <h2>Comp Report</h2>
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