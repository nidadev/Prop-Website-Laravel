<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="robots" content="noindex,nofollow" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Prop Estate</title>
	<link href="http://165.140.69.88/~plotplaza/realtor_zip/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://165.140.69.88/~plotplaza/realtor_zip/css/font-awesome.min.css" rel="stylesheet">
	<link href="{{ asset('css/global.css' )}}" rel="stylesheet">
	<link href="{{ asset('css/index.css' )}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans&display=swap" rel="stylesheet">
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</head>

<body>
	@include('layouts.nav')
	<section id="center" class="center_h">
		<div class="center_om">
			<div class="container-xl">
				<div class="row center_h1">
					<div class="col-md-12">
						<h1 class="text-white font_45"><span class="col_blue">PROPELYZE</span><br>All-In-One Acquisition Tool <br> for <span class="col_blue">Real Estate Marketing Campaigns</span></h1>
						<p class="text-white mt-3 fs-5">Explore comprehensive data for every county across the nation to identify potential markets or gain insights into regional economic trends.</p>
						<ul class="mb-0 mt-4">
							<li class="d-inline-block"><a class="button" href="#"><i class="fa fa-home me-1 align-middle fs-5"></i> Land </a></li>
							<li class="d-inline-block ms-2"><a class="button_1" href="#"><i class="fa fa-building me-1 fs-5 align-middle"></i> Houses </a></li>
						</ul>
					</div>
				</div>

	</section>

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
				<div class="col-md-4">
					<div class="work_h2i p-4 rounded_10 shadow_box text-center">
						<span class="d-inline-block bg_blue text-white rounded-circle fs-1"><i class="fa fa-map-signs"></i></span>
						<h5 class="mt-3 mb-3">01. Launching your real estate marketing campaign</h5>
						<p class="mb-0">It is now simpler than ever. Propelyze enables you to quickly identify target areas, set pricing, access property owner details, and clean your data, all in just moments! </p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="work_h2i p-4 rounded_10 shadow_box text-center">
						<span class="d-inline-block bg-danger text-white rounded-circle fs-1"><i class="fa fa-home"></i></span>
						<h5 class="mt-3 mb-3">02. Research</h5>
						<p class="mb-0">We streamline research, comparison, and data management, giving you more time to focus on successful property flips.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="work_h2i p-4 rounded_10 shadow_box text-center">
						<span class="d-inline-block bg-success text-white rounded-circle fs-1"><i class="fa fa-ticket"></i></span>
						<h5 class="mt-3 mb-3">03. Services</h5>
						<p class="mb-0">Our services cover both Vacant Land and Residential Properties, with all data updated in real time from DataTree.</p>
					</div>
				</div>
			</div>
		</div>
	</section>


	<!--section id="explore" class="pt-5 pb-5 bg_blue carousel_p">
		<div class="container-xl">
			<div class="row explore_1">
				<div class="col-md-4">
					<div class="explore_1l">
						<h3 class="text-white">Explore by <br> Property Type</h3>
						<hr class="line">
						<p class="mb-0 text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis mollis et sem sed</p>
					</div>
				</div>
				<div class="col-md-8">
					<div class="explore_1r">
						<div id="carouselExampleCaptions1" class="carousel slide" data-bs-ride="carousel">
							<div class="carousel-indicators">
								<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
								<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="1" aria-label="Slide 2" class="" aria-current="true"></button>
							</div>
							<div class="carousel-inner">
								<div class="carousel-item active">
									<div class="explore_1ri row">
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-building"></i></span>
												<h5 class="mt-3 mb-3">Apartment</h5>
												<h6 class="mb-0 text-muted">32 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-hotel"></i></span>
												<h5 class="mt-3 mb-3">Vilas</h5>
												<h6 class="mb-0 text-muted">34 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-home"></i></span>
												<h5 class="mt-3 mb-3">Houses</h5>
												<h6 class="mb-0 text-muted">33 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-building-o"></i></span>
												<h5 class="mt-3 mb-3">Offices</h5>
												<h6 class="mb-0 text-muted">24 Properties</h6>
											</div>
										</div>
									</div>
								</div>
								<div class="carousel-item">
									<div class="explore_1ri row">
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-building"></i></span>
												<h5 class="mt-3 mb-3">Apartment</h5>
												<h6 class="mb-0 text-muted">32 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-hotel"></i></span>
												<h5 class="mt-3 mb-3">Vilas</h5>
												<h6 class="mb-0 text-muted">34 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-home"></i></span>
												<h5 class="mt-3 mb-3">Houses</h5>
												<h6 class="mb-0 text-muted">33 Properties</h6>
											</div>
										</div>
										<div class="col-md-3 col-sm-6">
											<div class="explore_1ril bg-white rounded_10 p-4 px-3 text-center">
												<span class="font_50 lh-1 col_blue"><i class="fa fa-building-o"></i></span>
												<h5 class="mt-3 mb-3">Offices</h5>
												<h6 class="mb-0 text-muted">24 Properties</h6>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section-->

	<section id="testim" class="p_3 bg_blue carousel_p">
		<div class="container-xl">
			<div class="row work_h1 text-center mb-4">
				<div class="col-md-12">
					<h2 class="text-white">Testimonials</h2>
					<hr class="line mx-auto">
					<p class="mb-0 text-light">What our happy client says</p>
				</div>
			</div>
			<div class="testim_1 row">
				<div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-indicators">
						<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
						<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
					</div>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<div class="testim_1i row">
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/8.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Eget Nulla <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o"></i>
										</span>

									</div>
								</div>
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/9.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Dolor Porta <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i>
										</span>

									</div>
								</div>
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/10.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Quis Ipsum <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>

									</div>
								</div>
							</div>
						</div>
						<div class="carousel-item">
							<div class="testim_1i row">
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/11.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Eget Nulla <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o"></i>
										</span>

									</div>
								</div>
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/12.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Dolor Porta <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-half-o"></i>
										</span>

									</div>
								</div>
								<div class="col-md-4">
									<div class="testim_1i1 bg-white p-4 text-center rounded_10">
										<img src="{{ asset('img/13.jpg') }}" alt="abc" class="rounded-circle">
										<p class="mt-3">Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...Omnis velit quia. Perspiciatis et cupiditate. Voluptatum beatae asperiores dolor magnam fuga. Sed fuga est harum quo nesciunt sint. Optio veniam...</p>
										<h6 class="fw-bold  lh-base mt-3 fs-5"> Quis Ipsum <br> <span class="col_blue fs-6   fw-normal">User</span></h6>
										<span class="text-warning">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
										</span>

									</div>
								</div>
							</div>
						</div>
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
										<h4 class="plan_blue">Standard</h4>
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
										<h4 class="plan_orange">Professional</h4>
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
										<h4 class="plan_green">Enterprise</h4>
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
										<h4 class="plan_red">Popular</h4>
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
										<h4 class="plan_blue">New Plan</h4>
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

	<section id="faq" class="p_3 bg-light">
		<div class="container-xl">
			<div class="faq_1 row">
				<div class="col-md-4">
					<div class="faq_1l">
						<img src="{{ asset('img/23.jpg') }}" class="w-100 rounded_10" alt="abc">
					</div>
				</div>
				<div class="col-md-8">
					<div class="faq_1r">
						<h2>Frequently Asked Questions</h2>
						<hr class="line">
						<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia <br> consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt</p>
						<div class="accordion" id="accordionExample">
							<div class="accordion-item">
								<h2 class="accordion-header" id="headingOne">
									<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
										<i class="fa fa-check-circle me-2"></i> 1. What are the costs to buy a house?
									</button>
								</h2>
								<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
									<div class="accordion-body">
										<p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingTwo">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
										<i class="fa fa-check-circle me-2"></i> 2. What are the steps to sell a house?
									</button>
								</h2>
								<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingThree">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										<i class="fa fa-check-circle me-2"></i> 3. Do you have loan consultants?
									</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFour">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
										<i class="fa fa-check-circle me-2"></i> 4. When will the project be completed?
									</button>
								</h2>
								<div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
									</div>
								</div>
							</div>

							<div class="accordion-item">
								<h2 class="accordion-header" id="headingFive">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
										<i class="fa fa-check-circle me-2"></i> 5.What are the steps to rent a house?
									</button>
								</h2>
								<div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
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
						<h2 class="text-white">Become a Real Estate Agent</h2>
						<hr class="line">
						<p class="text-light mb-0">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia <br> consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="reg_1r text-end mt-4">
						<h6 class="mb-0"><a class="button" href="register.html">Register Now</a></h6>
					</div>
				</div>
			</div>
		</div>
	</section>

	@include('layouts.footer')

</body>

</html>