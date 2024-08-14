<section id="footer">
	<div class="footer_m bg_back p_3">
		<div class="container-xl">
			<div class="footer_1 row">
				<div class="col-md-4">
					<div class="footer_1l">
						<h4 class="text-white mb-4">Get Propelyze</h4>
						<p class="text-light">Subscribe Now</p>
						<h6 class="text-light"><i class="fa fa-phone-square col_blue me-1"></i> Office: +123 4567 890</h6>
						<h6 class="text-light mt-3"><i class="fa fa-envelope col_blue me-1"></i> support@propelyze.com</h6>
						<h6 class="text-light mt-3 mb-0"><i class="fa fa-map col_blue me-1"></i> USA</h6>
						<h4 class="mt-4 text-white">Connect With Us</h4>
						<ul class="mb-0 mt-3">
							<li class="d-inline-block"><a href="#"><i class="fa fa-facebook"></i></a></li>
							<li class="d-inline-block"><a href="#"><i class="fa fa-instagram"></i></a></li>
							<!--li class="d-inline-block"><a href="#"><i class="fa fa-behance"></i></a></li-->
							<li class="d-inline-block"><a href="#"><i class="fa fa-twitter"></i></a></li>
							<!--li class="d-inline-block"><a href="#"><i class="fa fa-pinterest"></i></a></li-->
							<li class="d-inline-block"><a href="#"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-8">
					<div class="footer_1r">
						<div class="footer_1ri row">
							<div class="col-md-4">
								<div class="footer_1ri1">
									<h4 class="text-white mb-4">Explore</h4>
									<div class="row footer_3ism">
										<h6 class="col-md-12 col-6"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Login</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Register</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Search Land</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Search Houses</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Comp Report</a></h6>
										<h6 class="col-md-12 col-6 mt-2 mb-0"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Research</a></h6>
									</div>
								</div>
							</div>
							
							
							<div class="col-md-4">
								<div class="footer_1ri1">
									<h4 class="text-white mb-4">Quick Links</h4>
									<div class="row footer_3ism">
										<h6 class="col-md-12 col-6"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> About</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Faq</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Our Terms</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Privacy Policy</a></h6>
										<h6 class="col-md-12 col-6 mt-2"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Refund Policy</a></h6>
										<h6 class="col-md-12 col-6 mt-2 mb-0"><a class="text-light" href="#"><i class="fa fa-chevron-right me-1 font_12 text-warning"></i> Contact</a></h6>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="footer_b" class="bg_dark pt-3 pb-3">
	<div class="container-xl">
		<div class="row footer_b1">
			<div class="col-md-12">
				<div class="footer_b1l text-center">
					<p class="mb-0 text-light">© 2024 Propelyze. All Rights Reserved </p>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	window.onscroll = function() {
		myFunction()
	};
	var navbar_sticky = document.getElementById("navbar_sticky");
	var sticky = navbar_sticky.offsetTop;
	var navbar_height = document.querySelector('.navbar').offsetHeight;

	function myFunction() {
		if (window.pageYOffset >= sticky + navbar_height) {
			navbar_sticky.classList.add("sticky")
			document.body.style.paddingTop = navbar_height + 'px';
		} else {
			navbar_sticky.classList.remove("sticky");
			document.body.style.paddingTop = '0'
		}
	}
</script>