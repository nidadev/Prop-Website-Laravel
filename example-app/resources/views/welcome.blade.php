@extends('layouts.app2')

@section('content')
<style>
	header {
  position: relative;
  background-color: black;
  height: 75vh;
  min-height: 25rem;
  width: 100%;
  overflow: hidden;
}

header video {
  position: absolute;
  top: 50%;
  left: 50%;
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: 0;
  -ms-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -webkit-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
}

header .container {
  position: relative;
  z-index: 2;
}

header .overlay {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  background-color: black;
  opacity: 0.5;
  z-index: 1;
}

/* Media Query for devices withi coarse pointers and no hover functionality */

/* This will use a fallback image instead of a video for devices that commonly do not support the HTML5 video element */

@media (pointer: coarse) and (hover: none) {
  header {
    background: url('{{ asset(($siteSettings['hero_image'] ?? '') ?: 'img/1.jpg') }}') black no-repeat center center scroll;
  }

  header video {
    display: none;
  }
}
	</style>
<header>

  
  <div class="overlay"></div>

  
  <video poster="{{ asset(($siteSettings['hero_image'] ?? '') ?: 'img/1.jpg') }}" playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="{{ asset('file/vdo.mp4') }}" type="video/mp4">
  </video>

  
  <div class="container h-100">
    <div class="d-flex h-100 text-center align-items-center">
      <div class="w-100 text-white">
        
		<h1 class="text-white font_45"><span class="col_blue">We </span>Simplify Your<span class="col_blue"> Search</span></h1>
					 
                     <p class="text-white mt-3 fs-5">  Empower Your Real Estate Campaigns with Precision and Speed</p>
						<ul class="mb-0 mt-4">
							<li class="d-inline-block"><a class="button" href="{{ url('/register')}}"><i class="fa fa-home me-1 align-middle fs-5"></i> Land </a></li>
							<li class="d-inline-block ms-2"><a class="button_1" href="{{ url('/register')}}"><i class="fa fa-building me-1 fs-5 align-middle"></i> Houses </a></li>
						</ul>
      </div>
    </div>
  </div>
</header>
@if(!config('property.datatree_enabled',true))<div class="container-xl mt-3"><p class="alert alert-info">Property searches and owner reports are temporarily unavailable. Land valuation, land comparables and market research remain available to eligible accounts.</p></div>@endif
	
		
                     

	<section id="work_h" class="p_3">
		<div class="container-xl">
			<div class="row work_h1 text-center mb-4">
				<div class="col-md-12">
					<h2>How It Works</h2>
					<hr class="line mx-auto">
					<p class="mb-0"></p>
				</div>
			</div>
			<div class="row work_h2">
				<div class="col-md-12">
					<div class="work_h2i p-4 rounded_10 shadow_box text-center">
						<p class="mb-0">Launching your real estate marketing campaign is now simpler than ever. Propelyze enables you to quickly identify target areas, set pricing, access property owner details, and clean your data, all in just moments! We streamline research, comparison, and data management, giving you more time to focus on successful property flips.

Our services cover both Vacant Land and Residential Properties, with property records supplied through connected data providers.
</p>
					</div>
				</div>
				
	
			</div>
		</div>
	</section>

	<section id="work_h" class="pt-5 pb-5 bg_blue">
   <div class="container-xl">
	  <div class="row work_h1 text-center mb-4">
		 <div class="col-md-12">
		   <h2 class="text-white">Services</h2>
		   <hr class="line mx-auto">
		   <p class="mb-0 text-white">What We Do</p>
		 </div>
	  </div>
	  <div class="row work_h2 text-white service-card-grid">
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center" style="background: #6C60FE;">
			  <span class="d-inline-block bg-warning text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/research')}}"><i class="fa fa-globe"></i></a></span>
			  <h5 class="mt-3 mb-3">Location Research</h5>
			  <p class="mb-0 text-white">Explore comprehensive data for every county across the nation to identify potential markets or gain insights into regional economic trends.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-danger text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/priceland')}}"><i class="fa fa-download"></i></a></span>
			  <h5 class="mt-3 mb-3">Owner Record Download</h5>
			  <p class="mb-0 text-white">Easily obtain property details that match your search criteria directly through our integrated data sources. </p><br>
			</div>
		 </div>
		
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/support')}}"><i class="fa fa-phone"></i></a></span>
			  <h5 class="mt-3 mb-3">Skip Tracing</h5>
			  <p class="mb-0 text-white">Automated skip tracing is not currently enabled. Contact support to discuss coverage and availability.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-danger text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/land-valuation')}}"><i class="fa fa-tag"></i></a></span>
			  <h5 class="mt-3 mb-3">Property Pricing</h5>
			  <p class="mb-0 text-white">Get personalized pricing for each property to boost your marketing impact.</p><br>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/list-upload')}}"><i class="fa fa-upload"></i></a></span>
			  <h5 class="mt-3 mb-3"> External List Uploading</h5>
			  <p class="mb-0 text-white">Import your existing owner records from other sources, and we will promptly apply pricing to them for you.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-warning text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/list-upload')}}"><i class="fa fa-table"></i></a></span>
			  <h5 class="mt-3 mb-3"> Data Scrubbing</h5>
			  <p class="mb-0 text-white">Validate CSV or XLSX APN lists, identify missing fields and remove duplicate parcel entries before pricing.</p><br>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/support')}}"><i class="fa fa-road"></i></a></span>
			  <h5 class="mt-3 mb-3">Road Access</h5>
			  <p class="mb-0 text-white">Automated road-access analysis is not currently available. Confirm legal access independently before purchasing.</p><br>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-danger text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/support')}}"><i class="fa fa-envelope"></i></a></span>
			  <h5 class="mt-3 mb-3"> Topography</h5>
			  <p class="mb-0 text-white">Automated terrain analysis is not currently available. Contact support about the data needed to assess usable acreage.</p><br>
			</div>
		 </div>
		
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/land-comps')}}"><i class="fa fa-globe"></i></a></span>
			  <h5 class="mt-3 mb-3">Campaign Mapping</h5>
			  <p class="mb-0 text-white">Property KML exports are deferred while DataTree access is resolved. Saved land comparables include a location map.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-warning text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/land-valuation')}}"><i class="fa fa-file"></i></a></span>
			  <h5 class="mt-3 mb-3"> Comp Reporting</h5>
			  <p class="mb-0 text-white">Download available land valuation reports with sourced comparable records. Owner and house reports await DataTree access.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/api-information')}}"><i class="fa fa-laptop"></i></a></span>
			  <h5 class="mt-3 mb-3"> Comp API</h5>
			  <p class="mb-0 text-white">Access available comparable property records through supported data services.</p><br>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-danger text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/support')}}"><i class="fa fa-user-plus"></i></a></span>
			  <h5 class="mt-3 mb-3"> Strategic Partnership</h5>
			  <p class="mb-0 text-white">Connect with industry experts, including investors, educators, and professionals to elevate your business ventures.</p>
			</div>
		 </div>
		 <div class="col-md-4">
		    <div class="work_h2i p-4 rounded_10 shadow_box text-center mt-3"  style="background: #6C60FE;">
			  <span class="d-inline-block bg-success text-white rounded-circle fs-1"><a class="text-white" href="{{ url('/support')}}"><i class="fa fa-check"></i></a></span>
			  <h5 class="mt-3 mb-3">Consulting</h5>
			  <p class="mb-0 text-white">Engage with our specialists to discuss land investment strategies, data analysis techniques, research methods, and more.</p>
			</div>
		 </div>
	  </div>
 </div>   
 </section>
	

    @if(!empty($siteSettings['youtube_embed_url']))
    <section class="container-xl py-5"><h2>See how Propelyze works</h2><div class="ratio ratio-16x9"><iframe src="{{ $siteSettings['youtube_embed_url'] }}" title="How Propelyze works" loading="lazy" allowfullscreen></iframe></div></section>
    @endif
	@include('partials.public-pricing')

	<section id="faq" class="p_3 bg-light">
		<div class="container-xl">
			<div class="faq_1 row">
				<div class="col-md-4">
					<div class="faq_1l">
						<img src="{{ asset('img/23.jpg') }}" class="w-100 rounded_10" alt="">
					</div>
				</div>
				<div class="col-md-8">
					<div class="faq_1r">
						<h2>Frequently Asked Questions</h2>
						<hr class="line">
						
						<div class="accordion" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-check-circle me-2"></i> What Is Propelyze?
									</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
									<div class="accordion-body">
										<p class="mb-0">Propelyze is a robust real estate marketing platform designed to streamline your direct mail and digital marketing campaigns. It offers tools for targeting specific areas, pricing mailers, accessing property records, and cleaning your lists for efficient use with your marketing or mailing services.</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTwo">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<i class="fa fa-check-circle me-2"></i> What Benefits Does Propelyze Offer?
									</button>
								</h2>
								<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Propelyze enhances your marketing efforts by providing in-depth research, competitive pricing models, and advanced location analysis. Our platform simplifies the process of targeting and pricing, ultimately boosting the efficiency of your marketing campaigns.</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingThree">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<i class="fa fa-check-circle me-2"></i> Can Propelyze Handle More Than Just Pricing?
									</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Yes, Propelyze is a comprehensive tool that includes features for research, rapid location searches, property analysis, record access, and list management. This all-in-one approach ensures that your marketing campaigns are well-supported from start to finish.</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFour">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										<i class="fa fa-check-circle me-2"></i>Does Propelyze Require Me to Learn a New Pricing Method?
									</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Not at all. Propelyze is designed to integrate with and enhance your existing pricing methods, automating the processes you are already familiar with for greater efficiency.</p>
									</div>
								</div>
							</div>							

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFive">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										<i class="fa fa-check-circle me-2"></i> Is Propelyze a Fully Automated System?
									</button>
								</h2>
								<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">While Propelyze offers significant automation, it cannot replace your decision-making. You will still need to make strategic choices regarding your mailing targets and the content of your offers.</p>
									</div>
								</div>
							</div>

							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="reg" class="pt-5 pb-5 bg_blue">
		<div class="container-xl">
			<div class="reg_1 row">
				<div class="col-md-9">
					<div class="reg_1l">
						<h2 class="text-white">Become a Member</h2>
						<hr class="line">
						<p class="text-light mb-0"></p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="reg_1r text-end mt-4">
						<h6 class="mb-0"><a class="bg-warning button" href="{{ url('/register')}}">Register Now</a></h6>
					</div>
				</div>
			</div>
		</div>
	</section>
@include('partials.support-assistant')
@endsection