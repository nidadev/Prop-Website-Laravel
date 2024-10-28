@extends('layouts.app2')
@section('content')
<section id="center" class="center_reg">
    <div class="center_om bg_backo">
        <div class="container-xl">
            <div class="row center_o1 m-auto text-center">
                <div class="col-md-12">
                    <h2 class="text-white">Subscription</h2>
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
		 <div class="col-md-4">
		    <div class="subs_1r text-end">
			   
			</div>
		 </div>
	  </div> 
	  <div class="subs_2 row">
	 <div class="col-md-12">
	   <div class="tab-content">
    <div class="tab-pane active" id="home">
      <div class="subs_2i row">
      @php
    $currentPlan = app('subscription_helper')->getCurrentSubscription();
    @endphp
    @foreach($plans as $plan)
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
      @if($plan->name == 'Monthly Bronze')
		 <h4 class="plan_green">{{ $plan->name}} @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id) (Active)@endif
     ${{ $plan->amount}} Charge</h4>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Research and Analytics</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Location Searching</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Location Analysis and Model Offer Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> View Comps</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Owner/Property Record Exporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> External List Upload Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Comp Reporting
     </h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Full Customer Support
     </h6>
     @endif
      @if($plan->name == 'Monthly')
		 <h4 class="plan_blue">{{ $plan->name}} @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id) (Active)@endif
     ${{ $plan->amount}} Charge</h4>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Research and Analytics</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Location Searching</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Location Analysis and Model Offer Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> View Comps</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Owner/Property Record Exporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> External List Upload Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Comp Reporting
     </h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 col_blue"></i> Full Customer Support
     </h6>
     @endif
     
     @if($plan->name == 'Yearly')
     <h4 class="plan_orange">{{ $plan->name}} @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id) (Active)@endif
     ${{ $plan->amount}} Charge</h4>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Research and Analytics</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Searching</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Location Analysis and Model Offer Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> View Comps</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Owner/Property Record Exporting</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> External List Upload Pricing</h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Comp Reporting
     </h6>
		 <h6 class="mt-3"><i class="fa fa-check-square-o me-1 text-warning"></i> Full Customer Support
     </h6>
     @endif
		 @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id)
        <!--button class="btn btn-danger subscriptionCancel" style="width:100%;">Cancel</button-->

        @else
        <button class="btn btn-primary text-center d-block confirmationBtn" data-id="{{ $plan->id }}" data-toggle="modal" data-target="#confirmationModal" style="width:100%;">Start Free Trial</button>

        @endif
		</div>
	   </div>
     @endforeach

	  </div>
    </div>
    <!--div class="tab-pane" id="profile">
         <div class="subs_2i row">
	   <div class="col-md-4">
	    <div class="subs_2i1 border_1 rounded_10 p-4">
		 <h4 class="plan_blue">Yearly</h4>
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
  
	  </div>
    </div-->
    
</div>
	 </div>
	</div>
  </div>   
 </section>
<!----------------------------------- -->
 <!--div class="container">
  <div class="row">
    @php
    $currentPlan = app('subscription_helper')->getCurrentSubscription();
    @endphp
    @foreach($plans as $plan)
    <div class="col-sm-4">
      <div class="card">
        <h2>{{ $plan->name}} @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id) (Active)@endif</h2>
        <h2>${{ $plan->amount}} Charge</h2>
        @if($currentPlan && $currentPlan->subscription_plan_price_id == $plan->stripe_price_id)
        <button class="btn btn-danger subscriptionCancel">Cancel</button>

        @else
        <button class="btn btn-primary confirmationBtn" data-id="{{ $plan->id }}" data-toggle="modal" data-target="#confirmationModal">subscribe</button>

        @endif
      </div>
    </div>
    @endforeach
  </div>
</div-->

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmationModalTitle">...</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="confirmation-data">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary continueBuyPlan">Continue</button>
      </div>
    </div>
  </div>
</div>

<!----------------------->
<!-- Stripe Modal -->
<div class="modal fade" id="stripeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stripeModalTitle">Buy subscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="planId" id="planId">
        <!-- stripe card -->
        <div id="card-element"></div>
        <!-- stripe card errors -->

        <div id="card-errors" style="color:red;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="buyPlanSubmit" class="btn btn-primary">Buy Plan</button>
      </div>
    </div>
  </div>
</div>
<!------>
@endsection
@push('scripts')
<script src="https://js.stripe.com/v3"></script>
<script>
  console.log('hii');
  $(document).ready(function() {
    $('.confirmationBtn').click(function() {
      var planId = $(this).data('id');
      $('#planId').val(planId);


      $.ajax({
        type: 'POST',
        url: '{{ route("getPlanDetails") }}',
        data: {
          id: planId,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.success) {
            var data = response.data;
            console.log(data);
            var html = '';
            $('#confirmationModalTitle').text(data.name + ' {$' + data.amount + '}');
            html += `<p>` + response.msg + `</p>`;
            console.log(html);
            $('.confirmation-data').html(html);
          } else {
            alert('something went wrong');
          }

        },

      });


    });
    $('.continueBuyPlan').click(function() {
      //alert('');
      $("#confirmationModal").modal('hide');
      $("#stripeModal").modal('show');

    });
    //subscription cancel
    $('.subscriptionCancel').click(function() {
      var obj = $(this);
     $(obj).html('Please wait ...<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
     $(obj).attr('disabled','disabled'); 
     //alert('');
      $.ajax({
        type: 'POST',
        url: '{{ route("CancelSubscription") }}',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.success) {
            console.log(response);
            alert(response.msg);
            window.location.reload();
          } else {
            alert('something wrong');
            $(obj).html('Cancel');
            $(obj).removeAttr('disabled'); 

          }

        },

      });

    });


  });
  //stripe code start
  if (window.Stripe) {
    var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY')}}");
    //create an instan of card elemnt
    var elements = stripe.elements();
    var card = elements.create("card", {
      hidePostalCode: true
    });
    //add instan of card elemn into the card elem div
    card.mount('#card-element');
    card.addEventListener('change', function(event) {
      var displayerror = document.getElementById('card-errors');
      if (event.error) {
        displayerror.textContent = event.error.message;
      } else {
        displayerror.textContent = '';
      }
    });
    //handle form submission and create token
    var submitBtn = document.getElementById('buyPlanSubmit');

    submitBtn.addEventListener('click', function(ev) {
      submitBtn.innerHTML = 'Please wait ...<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>';
      submitBtn.setAttribute("disabled", "disabled");
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
          submitBtn.innerHTML = 'Buy Plan';
          submitBtn.removeAttribute("disabled");
        } else {
          console.log(result);
          //alert(result.token);
          createSubscription(result.token);
        }
      });
    });

  }

  function createSubscription(token) {

    var planID = $('#planId').val();
    //alert(planID);
    //alert(token.id);
    //alert(csrf_token());
    $.ajax({
      url: "{{ route('CreateSubscription')}}",
      type: "POST",
      data: {plan_id:planID, data:token, _token: "{{ csrf_token() }}"},
      success: function(response) {
        //alert(data._token);
        //alert(response.success);
        if (response.success) {
          console.log(response);
          alert(response.msg);
          window.location.reload();
        } else {
          //alert(data);
          //alert(response);
          console.log(response);
          alert('something wrong');
          $('#buyPlanSubmit').html("Buy Plan");

          $('#buyPlanSubmit').removeAttr("disabled");
        }

      }


    });
  }
</script>
@endpush