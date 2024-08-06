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
        <select class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
  <option selected>search By</option>
  <option value="1">State Name</option>
</select>		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="center_h2lil">
		 <select class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
  <option selected>search By</option>
  <option value="1">County Name</option>
</select>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="center_h2lil">
        <select class="form-select border-0 rounded_10 bg-light" aria-label="Default select example">
  <option selected>search By</option>
  <option value="1">Total Comps</option>
  <option value="2">Sale Comps</option>
  <option value="3">Sold Comps</option>
  
</select>		</div>
	   </div>
	 </div>
	</div>
   </div>
   <div class="col-md-4">
    <div class="center_h2r">
	 <div class="center_h2ri row">
	  <div class="col-md-4">
	   <div class="center_h2ril">
	     <input class="form-control border-0 rounded_10 bg-light" value="246283880" id="loc" name="location" placeholder="ZipCode" type="text">
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
		   <h2>Search Results</h2>
		   <hr class="line mx-auto">
		 </div>
	  </div>
	  <div class="row work_h2">
		 <div class="col-md-12">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center">
            <form>
   
     <table class="display" style="width:100%" id="myDataTable">
                    <thead class="bg-grey-50">
        <tr>
            <td>Bathrooms</td>
            <td>Bedrooms</td>
            <td>State</td>
            <td>Price</td>           
            <!--td>Assessed Value</td-->
            <td>Living area</td>
            <td>City</td>
            <td>Status</td>
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
</noscript><object class='tableauViz'  style='display:none;'><param name='host_url' value='https%3A%2F%2Fpublic.tableau.com%2F' /> <param name='embed_code_version' value='3' /> <param name='path' value='shared&#47;C8TN4FWZ3' /> <param name='toolbar' value='yes' /><param name='static_image' value='https:&#47;&#47;public.tableau.com&#47;static&#47;images&#47;C8&#47;C8TN4FWZ3&#47;1.png' /> <param name='animate_transition' value='yes' /><param name='display_static_image' value='yes' /><param name='display_spinner' value='yes' /><param name='display_overlay' value='yes' /><param name='display_count' value='yes' /><param name='language' value='en-US' /></object></div>                <script type='text/javascript'>                    var divElement = document.getElementById('viz1722762005819');                    var vizElement = divElement.getElementsByTagName('object')[0];                    vizElement.style.width='100%';vizElement.style.height=(divElement.offsetWidth*0.75)+'px';                    var scriptElement = document.createElement('script');                    scriptElement.src = 'https://public.tableau.com/javascripts/api/viz_v1.js';                    vizElement.parentNode.insertBefore(scriptElement, vizElement);                </script>

   </div>
	 
 </section>

 
@endsection
<script>
    
</script>
</body>
</html>