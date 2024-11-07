@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">Pricing Plan</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Subscription </h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="subs" class="p_3">
   <div class="container-xl">
	 <div class="row subs_1 mb-4">
		 <div class="col-md-8">
		    <div class="subs_1l">
			  <h2>Pricing & Subscriptions</h2>
		   <hr class="line">
			</div>
		 </div>
		
	  </div> 
	  <div class="subs_2 row">
	 <div class="col-md-12">
	   <div class="tab-content">
    <div class="tab-pane active" id="home">
      <div class="subs_2i row">
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_red">Monthly $34.99</h4>
         <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Research and Analytics</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Searching</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Analysis and Model Offer Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> View Comps</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Owner/Property Record Exporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> External List Upload Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Comp Reporting
     </h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Full Customer Support
     </h6> <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="{{ url('/register')}}">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_green">Monthly Bronze $49.99</h4>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Research and Analytics</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Searching</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Analysis and Model Offer Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> View Comps</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Owner/Property Record Exporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Comp Reporting</h6>
		 
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Full Customer Support</h6> 
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="{{ url('/register')}}">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_orange" style="border-radius:21px;background-color:#ffc107;color:#fff;">Gold $499</h4>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 40 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 24 Hrs Support and Model Offer Pricing</h6>
         <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Impact Reporting</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="{{ url('/register')}}">Get Quote </a></h6>
		</div>
	   </div>
	  </div>
    </div>
    
    
</div>
	 </div>
	</div>
  </div>   
 </section>
@endsection


</body>

</html>