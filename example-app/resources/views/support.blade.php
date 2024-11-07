@extends('layouts.app2')

@section('content')
<section id="center" class="center_cont">
   <div class="center_om bg_backo">
     <div class="container-xl">
  <div class="row center_o1 m-auto text-center">
     <div class="col-md-12">
	          <h2 class="text-white">Contact Us</h2>
		  <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Contact Us </h6>
	 </div>
  </div>
 </div>
   </div>   
</section>
@if(Session::has('error'))
        <p class="incorrect">{{ Session::get('error') }}</p>

        @endif
       


<section id="contact_o" class="p_3">
   <div class="container-xl">
	  <div class="contact_2 row">
	  @if(Session::has('success'))
        <p class="result">{{ Session::get('success') }}</p>

        @endif
	   <div class="col-md-6">
	    <div class="contact_2l border_1 p-4">
		<form method="post" action="{{ route('contactForm') }}">
		@csrf
		   <h4>Get In Touch</h4>
		   <hr>
		   <div class="contact_2li row">
		    <div class="col-md-12">
			 <div class="contact_2lil">
			  <h6 class="fw-bold font_14 mb-2">Your Name</h6>
			  <input class="form-control rounded_10 border-0 bg-light" placeholder="Your Name" type="text" name="name">
			  <span class="error email_err">@error('name') {{$message}} @enderror</span>
 
			</div>
			</div>
		   </div>
		   <div class="contact_2li row mt-4">
		    <div class="col-md-6">
			 <div class="contact_2lil">
			  <h6 class="fw-bold font_14 mb-2">Phone Number</h6>
			  <input class="form-control rounded_10 border-0 bg-light" placeholder="Your Phone" type="text" name="phone">
			  <span class="error email_err">@error('phone') {{$message}} @enderror</span>
 
			</div>
			</div>
			<div class="col-md-6">
			 <div class="contact_2lil">
			  <h6 class="fw-bold font_14 mb-2">Email Address</h6>
			  <input class="form-control rounded_10 border-0 bg-light" placeholder="Your Email" type="text" name="email">
			  <span class="error email_err">@error('email') {{$message}} @enderror</span>
 
			</div>
			</div>
		   </div>
		   <div class="contact_2li row mt-4">
		    <div class="col-md-6">
			<div class="contact_2lil">
			<h6 class="fw-bold font_14 mb-2">Subject</h6>
			  <input class="form-control rounded_10 border-0 bg-light" placeholder="Enter Subject" type="text" name="subject">
			
			</div>
		
			 
			</div>
			<div class="col-md-6">
			 
			</div>
		   </div>
		   <div class="contact_2li row mt-4">
		    <div class="col-md-12">
			 <div class="contact_2lil">
			  <h6 class="fw-bold font_14 mb-2">Description</h6>
			  <textarea class="form-control rounded_10 border-0 bg-light form_text" placeholder="Comments" name="comment"></textarea>
			  <span class="error email_err">@error('comment') {{$message}} @enderror</span>

			  <h6 class="mb-0 mt-3 center_sm">          <button type="submit" style="border:none;" class="button_2 b-block text-center" >Submit</button></h6>

			</h6>
			 </div>
			</div>
		   </div>
		</form>
		</div>
	   </div>
	   <div class="col-md-6">
	    <div class="contact_2r">
		  <h4 class="mb-4">Contact Details</h4>
		  <div class="contact_2ri row">
		   <div class="col-md-2 col-2">
		  
		   </div>
		   <div class="col-md-10 col-10">
		   
		   </div>
		  </div>
		  <div class="contact_2ri row mt-4">
		   <div class="col-md-2 col-2">
		    <div class="contact_2ril">
			 <span class="d-inline-block border_1 text-center col_blue fs-4 rounded_10"><i class="fa fa-envelope"></i></span>
			</div>
		   </div>
		   <div class="col-md-10 col-10">
		    <div class="contact_2rir">
			 <h5>Email Us</h5>
			 <h6 class="mb-0"><a href="#">support@propelyze.com</a> </h6>
			</div>
		   </div>
		  </div>
		  <!--div class="contact_2ri row mt-4">
		   <div class="col-md-2 col-2">
		    <div class="contact_2ril">
			 <span class="d-inline-block border_1 text-center col_blue fs-4 rounded_10"><i class="fa fa-map"></i></span>
			</div>
		   </div>
		   <div class="col-md-10 col-10">
		    <div class="contact_2rir">
			 <h5>Location</h5>
			 <h6 class="mb-0">JK. Lorem Kaya, No.12, Porta United States </h6>
			</div>
		   </div>
		  </div>
		  <h4 class="mt-4 mb-4">Find Us On</h4>
		  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114964.53925916665!2d-80.29949920266738!3d25.782390733064336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d9b0a20ec8c111%3A0xff96f271ddad4f65!2sMiami%2C+FL%2C+USA!5e0!3m2!1sen!2sin!4v1530774403788" height="330" style="border:0; width:100%;" allowfullscreen=""></iframe-->
		</div>
	   </div>
	  </div>
	  
 </div>   
</section>


@endsection

<style>
    span,
    .incorrect {
        color: red;
    }

    p.result {
        color: green;
    }
</style>

</body>

</html>