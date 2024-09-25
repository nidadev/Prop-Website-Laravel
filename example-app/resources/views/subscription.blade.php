

@extends('layouts.layout')
@section('content')
<h1>Subscription</h1>
<div class="container">
	<div class="row">
		@foreach($plans as $plan)
		<div class="col-sm-4">
<div class="card">
	<h2>{{ $plan->name}}</h2>
	<h2>${{ $plan->amount}} Charge</h2>
	<button class="btn btn-primary confirmationBtn" data-id="{{ $plan->id }}" data-toggle="modal" data-target="#confirmationModal">subscribe</button>
</div>
		</div>
		@endforeach
	</div>
</div>

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
  $(document).ready(function()
  {
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
              var html = '';
              $('#confirmationModalTitle').text(data.name + ' {$' + data.amount + '}');
              html += `<p>` + response.msg + `</p>`;
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
  });
//stripe code start
if(window.Stripe)
{
  var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY')}}");
  //create an instan of card elemnt
  var elemnts = stripe.elements();
  var card = elemnts.create("card",{
    hidePostalCode:true
  });
  //add instan of card elemn into the card elem div
  card.mount('#card-element');
  card.addEventListener('change',function(event)
  {
    var displayerror = document.getElementById('card-errors');
    if(event.error)
  {
    displayerror.textContent = event.error.message;
  }
  else
  {
    displayerror.textContent = '';
  }
  });
    //handle form submission and create token
    var submitBtn = document.getElementById('buyPlanSubmit');


    submitBtn.addEventListener('click',function(ev)
    {
      submitBtn.innerHTML = 'Please wait ...<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>';
      submitBtn.setAttribute("disabled","disabled");
      stripe.createToken(card).then(function(result){
        if(result.error)
      {
        var errorElemnt = document.getElementById('card-errors');

        errorElemnt.textContent = result.error.message;
        submitBtn.innerHTML = 'Buy Plan';
      submitBtn.removeAttribute("disabled");
      }
      else
      {
        console.log(result);
        createSubscription(result.token);
      }
      });
    });

}

function createSubscription(token)
{
  var planID = $('#planId').val();
$.ajax(
{
  url: "{{ route('CreateSubscription')}}",
  type: "POST",
  data:{ plan_id: planID,data:token,_token: "{{ csrf_token() }}"},
  success:function(response)
  {
    if(response.success)
  {
 //console.log(response);
 alert(response.msg);
 window.location.reload();
  }
  else
  {
    alert('something wrong');
    $('#buyPlanSubmit').html("Buy Plan");

    $('#buyPlanSubmit').removeAttr("disabled");
  }

  }


});
}
</script>
@endpush