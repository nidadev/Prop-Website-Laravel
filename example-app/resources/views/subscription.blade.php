

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
        <button type="button" class="btn btn-primary">Continue</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
	console.log('hii');
</script>
@endpush