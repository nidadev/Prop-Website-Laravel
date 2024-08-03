@extends('layouts.app')

@section('main')

<section id="center" class="center_h">
   <div class="center_om">
     <div class="container-xl">
  <div class="row center_h1">
     <div class="col-md-12">
	 <ul class="mb-0 mt-4">
		  <li class="d-inline-block"><a class="button" href="#"><i class="fa fa-home me-1 align-middle fs-5"></i> Coverage Map </a></li>
          <li class="d-inline-block"><a class="button_1" href="#"><i class="fa fa-home me-1 align-middle fs-5"></i> Parcels on Market Map </a></li>
 
          <li class="d-inline-block ms-2"><a class="button_1" href="#"><i class="fa fa-building me-1 fs-5 align-middle"></i> Sold to For Sale Ratio Map</a></li>
		</ul>
	 </div>
  </div>
  <div class="row center_h2 mt-4 rounded_10 bg-white p-4 px-3 mx-0">
   <div class="col-md-8">
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
	  <div class="col-md-5">
	   <div class="center_h2ril">
	     <input class="form-control border-0 rounded_10 bg-light" placeholder="Acres" type="text">
	   </div>
	  </div>
	  <div class="col-md-5">
	   <div class="center_h2ril">
	    <input class="form-control border-0 rounded_10 bg-light" placeholder="Max Price" type="text">
	   </div>
	  </div>
	  <div class="col-md-2">
	   <div class="center_h2rir">
	    <span><a class="button" href="#"><i class="fa fa-search  fs-5"></i>  </a></span>
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
		   <p class="mb-0">Follow these 4 steps to book your place</p>
		 </div>
	  </div>
	  <div class="row work_h2">
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center">
			  <span class="d-inline-block bg_blue text-white rounded-circle fs-1"><i class="fa fa-map-signs"></i></span>
			  <h5 class="mt-3 mb-3">01. Search for Location</h5>
			  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis mollis et sem sed sollicitudin. Donec non odio…</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center">
			  <span class="d-inline-block bg-danger text-white rounded-circle fs-1"><i class="fa fa-home"></i></span>
			  <h5 class="mt-3 mb-3">02. Select Property Type</h5>
			  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis mollis et sem sed sollicitudin. Donec non odio…</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><i class="fa fa-ticket"></i></span>
			  <h5 class="mt-3 mb-3">03. Book Your Property</h5>
			  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis mollis et sem sed sollicitudin. Donec non odio…</p>
			</div>
		 </div>
	  </div>
 </div>   
 </section>
 
<section id="explore" class="pt-5 pb-5 bg_blue carousel_p">
   <div class="container-xl">
	 
 </section>

 
@endsection

</body>
</html>



