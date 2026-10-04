@extends('layouts.app2')

@section('content')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">About</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="{{ url('/home') }}">Home</a> <span class="mx-2 text-warning">/</span> About </h6>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="about" class="p_3">
    <div class="container-xl">
        <div class="about_1 row align-items-center g-4">
            <div class="col-md-6">
                <h2>About Propelyze</h2>
                <hr class="line">
                <p class="mt-3"> At Propelyze, we believe that your time is your most valuable asset. 
                That’s why we’ve made it our mission to streamline and enhance the property acquisition process, empowering land investors to make faster, more informed decisions. Our journey began with a simple but powerful idea: what if acquiring real estate could be less tedious and more efficient? With years of experience in real estate and a passion for technology, we set out to create a solution that would revolutionize the way investors approach direct mail marketing campaigns. No longer would identifying prime locations, pulling owner records, and pricing parcels be a time-consuming task—it would become a seamless experience.</p>
            </div>
            <div class="col-md-6">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item">
      <img src="{{ asset('img/27.jpg') }}" class="d-block w-100 rounded_10" alt="">
      
    </div>
    <div class="carousel-item">
      <img src="{{ asset('img/30.jpg') }}" class="d-block w-100 rounded_10" alt="">
      
    </div>
    <div class="carousel-item active">
      <img src="{{ asset('img/29.jpg') }}" class="d-block w-100 rounded_10" alt="">
      
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
            </div>
        </div>
        <div class="row disc_1 mt-5 g-4">
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/26.jpg') }}" class="w-100 rounded_10" alt="">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Research Property</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <a href="{{ url('/research') }}" aria-label="Research Property" class="d-inline-block bg-danger text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/21.jpg') }}" class="w-100 rounded_10" alt="">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Search Land / House</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <a href="{{ url('/priceland') }}" aria-label="Search Land / House" class="d-inline-block bg-warning text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/22.jpg') }}" class="w-100 rounded_10" alt="">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Analyze</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <a href="{{ url('/land-valuation') }}" aria-label="Analyze" class="d-inline-block bg_blight text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="about_pg" class="p_3">
    <div class="container-xl">
        <div class="about_pg1 row">
            <div class="col-md-6">
                <div class="about_pg1l reading-story">
                    <details class="reading-detail"><summary>Our Origin Story</summary><div class="reading-answer"><p class="mt-4">Back in 2019, we were in the same position as many land investors—working long hours, struggling to find the right properties to invest in, and trying to manage the complexities of direct mail marketing. We knew there had to be a better way, but the tools we needed simply didn’t exist. So, we decided to build them ourselves.</p>
                    <p>After countless late nights and a relentless focus on innovation, Propelyze was born. We created a powerful, easy-to-use platform that simplifies the entire acquisition process. By combining cutting-edge technology with our deep understanding of the real estate market, we developed a tool that turns what used to take days into a task that can be completed in minutes.</p></div></details></div>
                
            </div>
            <div class="col-md-6">
                <div class="about_pg1l reading-story">
                    <details class="reading-detail"><summary>Our Impact and Vision</summary><div class="reading-answer"><p class="mt-4">Since launching Propelyze, the feedback from our users has been nothing short of inspiring. We’ve seen how our platform has transformed the way real estate entrepreneurs work, saving them precious time and helping them close deals more efficiently. The success stories from our users drive us to continue innovating and expanding our offerings.</p>
                    <p>Our mission is clear: to provide a comprehensive and intuitive platform that enables land investors to focus on what truly matters—growing their business. We’re committed to continually refining our tools, listening to our users, and staying at the forefront of real estate technology.
                        As we look to the future, we’re excited about the endless possibilities for Propelyze. Our goal is to remain the go-to resource for real estate professionals who want to simplify their processes and maximize their success. With Propelyze by your side, you can propel your real estate business to new heights.
                    </p></div></details></div>
            </div>
        </div>
    </div>
</section>

<section id="about_pg" class="p_3">
    <div class="container-xl">
        <div class="about_pg1 row align-items-center rounded_10">
            
            <div class="col-md-6">
                <div class="about_pg1l rounded_10">
                    <img src="{{ asset('img/28.jpg') }}" class="w-100" alt="">
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="about_pg1l reading-story">
                    <h4>What’s Next for Propelyze?</h4>
                    <hr class="line">
                    <p class="mt-4">As we look ahead, our commitment to innovation remains stronger than ever. We’re excited to introduce new features that will continue to elevate your real estate investment experience.</p>

                    <h5>Upcoming Enhancements:</h5>
                    <p>
                        ● Advanced Bulk Comp Reports <br>
                        ● Migration Flow Analysis Heat Map<br>
                        ● Permit and Investor Activity Visualization<br>
                        ● Land Type-Specific Pricing Models<br>
                        ● Integrated Property Document Management<br>
                        ● Historical Pricing Trends and Forecasts<br>
                        ● Detailed Housing Comp Reports<br>
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
