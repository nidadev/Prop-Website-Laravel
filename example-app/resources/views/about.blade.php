@extends('layouts.app')

@section('main')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">About</h2>
                    <h6 class="text-white mb-0 mt-3"><a class="text-white" href="#">Home</a> <span class="mx-2 text-warning">/</span> Register </h6>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="about" class="p_3">
    <div class="container-xl">
        <div class="about_1 row">
            <div class="col-md-12">
                <h6 class="col_blue fw-bold">About Us Propelyze</h6>
                <p class="mt-3"> At Propelyze, we believe that your time is your most valuable asset. 
                That’s why we’ve made it our mission to streamline and enhance the property acquisition process, empowering real estate investors to make faster, more informed decisions.Our journey began with a simple but powerful idea: what if acquiring real estate could be less tedious and more efficient? With years of experience in real estate and a passion for technology, we set out to create a solution that would revolutionize the way investors approach direct mail marketing campaigns. No longer would identifying prime locations, pulling owner records, and pricing parcels be a time-consuming task—it would become a seamless experience.</p>
            </div>
        </div>
        <div class="row disc_1 mt-4">
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/20.jpg') }}" class="w-100 rounded_10" alt="abc">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Buy a Property</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <span class="d-inline-block bg-danger text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/21.jpg') }}" class="w-100 rounded_10" alt="abc">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Sell a Property</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <span class="d-inline-block bg-warning text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="disc_1i position-relative">
                    <div class="disc_1i1">
                        <img src="{{ asset('img/22.jpg') }}" class="w-100 rounded_10" alt="abc">
                    </div>
                    <div class="disc_1i2 position-absolute  rounded_10 shadow_box p-4">
                        <div class="disc_1i2i row">
                            <div class="col-md-9 col-9">
                                <div class="disc_1i2il">
                                    <h4 class="mb-0 mt-3">Rent a Property</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-3">
                                <div class="disc_1i2ir text-end">
                                    <span class="d-inline-block bg_blight text-white text-center rounded-circle fs-5"><i class="fa fa-long-arrow-right"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--section id="spec" class="pt-5 pb-5 bg-light">
    <div class="container-xl">
        <div class="row spec_1">
            <div class="col-md-3 col-sm-6">
                <div class="spec_1i text-center p-5 px-4 rounded_10 shadow_box bg-white">
                    <span class="font_60 col_red lh-1"><i class="fa fa-list-alt"></i></span>
                    <h1 class="mt-3">55K</h1>
                    <h6 class="mb-0">Listings Added</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="spec_1i text-center p-5 px-4 rounded_10 shadow_box bg-white">
                    <span class="font_60 col_red lh-1"><i class="fa fa-user-plus"></i></span>
                    <h1 class="mt-3">3200+</h1>
                    <h6 class="mb-0">Agents Listed</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="spec_1i text-center p-5 px-4 rounded_10 shadow_box bg-white">
                    <span class="font_60 col_red lh-1"><i class="fa fa-bullhorn"></i></span>
                    <h1 class="mt-3">2200+</h1>
                    <h6 class="mb-0">Sales Completed</h6>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="spec_1i text-center p-5 px-4 rounded_10 shadow_box bg-white">
                    <span class="font_60 col_red lh-1"><i class="fa fa-user"></i></span>
                    <h1 class="mt-3">5200+</h1>
                    <h6 class="mb-0">Users</h6>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                    <img src="img/8.jpg" alt="abc" class="rounded-circle">
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
                                    <img src="img/9.jpg" alt="abc" class="rounded-circle">
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
                                    <img src="img/10.jpg" alt="abc" class="rounded-circle">
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
                                    <img src="img/11.jpg" alt="abc" class="rounded-circle">
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
                                    <img src="img/12.jpg" alt="abc" class="rounded-circle">
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
                                    <img src="img/13.jpg" alt="abc" class="rounded-circle">
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
</section-->

<section id="about_pg" class="p_3">
    <div class="container-xl">
        <div class="about_pg1 row">
            <div class="col-md-12">
                <div class="about_pg1l mt-4">
                    <h3>"Our Origin Story"</h3>
                    <p class="mt-4">Back in 2019, we were in the same position as many real estate investors—working long hours, struggling to find the right properties to invest in, and trying to manage the complexities of direct mail marketing. We knew there had to be a better way, but the tools we needed simply didn’t exist. So, we decided to build them ourselves.</p>
                    <p>After countless late nights and a relentless focus on innovation, Propelyze was born. We created a powerful, easy-to-use platform that simplifies the entire acquisition process. By combining cutting-edge technology with our deep understanding of the real estate market, we developed a tool that turns what used to take days into a task that can be completed in minutes.</p>
                </div>
                <div class="about_pg1l mt-4">
                    <h3>"Our Impact and Vision"</h3>
                    <p class="mt-4">Since launching Propelyze, the feedback from our users has been nothing short of inspiring. We’ve seen how our platform has transformed the way real estate entrepreneurs work, saving them precious time and helping them close deals more efficiently. The success stories from our users drive us to continue innovating and expanding our offerings.</p>
                    <p>Our mission is clear: to provide a comprehensive and intuitive platform that enables real estate investors to focus on what truly matters—growing their business. We’re committed to continually refining our tools, listening to our users, and staying at the forefront of real estate technology.
                        As we look to the future, we’re excited about the endless possibilities for Propelyze. Our goal is to remain the go-to resource for real estate professionals who want to simplify their processes and maximize their success. With Propelyze by your side, you can propel your real estate business to new heights.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

<section id="about_pg" class="p_3">
    <div class="container-xl">
        <div class="about_pg1 row">
            <div class="col-md-6">
                <div class="about_pg1l mt-4">
                    <h3>"What’s Next for Propelyze?"</h3>
                    <p class="mt-4">As we look ahead, our commitment to innovation remains stronger than ever. We’re excited to introduce new features that will continue to elevate your real estate investment experience.</p>


                </div>

            </div>
            <div class="col-md-6">
                <div class="about_pg1l mt-4">

                    <h4>Upcoming Enhancements:</h4>
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