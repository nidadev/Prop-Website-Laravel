@extends('layouts.layout');
@section('content')
<h1>Subscription</h1>
@endsection
<!--@extends('layouts.app')

@section('main')
<section id="center" class="center_price">
   <div class="center_om bg_backo">
     <div class="container-xl">
  <div class="row center_o1 m-auto text-center">
     <div class="col-md-12">
	         <h2 class="text-white">Pricing Plan</h2>
		  <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Pricing Plan </h6>
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
		   <p class="mb-0">Checkout our package, choose your package wisely</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="subs_1r text-end">
			    <ul class="nav nav-tabs mb-0 border-0">
    <li class="nav-item d-inline-block me-2">
        <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
            <span class="d-md-block">Monthly</span>
        </a>
    </li>
    <li class="nav-item d-inline-block">
        <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
            <span class="d-md-block">Yearly</span>
        </a>
    </li>
</ul>
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
		 <h4 class="plan_red">Standard</h4>
		 <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 10 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_green">Professional</h4>
		 <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
		 
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 20 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_orange">Enterprise</h4>
		 <p class="mt-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 40 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	  </div>
    </div>
    <div class="tab-pane" id="profile">
         <div class="subs_2i row">
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_blue">Popular</h4>
		 <p class="mt-3">Omnis velit quia. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint.</p>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 60 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_orange">Trending</h4>
		 <p class="mt-3">Omnis velit quia. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint.</p>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 70 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_red">New Plan</h4>
		 <p class="mt-3">Omnis velit quia. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint.</p>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 90 Listing Per Login</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 110+ Users</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Enquiry On Listing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> 24 Hrs Support</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Custom Review</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Impact Reporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Onboarding & Account</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> API Access</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Transaction Tracking</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-success"></i> Branding</h6>
		 <h6 class="mb-0 mt-4"><a class="button text-center d-block" href="#">Get Quote </a></h6>
		</div>
	   </div>
	  </div>
    </div>
    
</div>
	 </div>
	</div>
  </div>   
 </section>
@endsection-->

</body>

</html>