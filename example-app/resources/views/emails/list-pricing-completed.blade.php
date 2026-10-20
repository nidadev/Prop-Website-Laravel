<h1>Your list pricing is ready</h1>
<p>Your Propelyze APN list {{ $uploadId }} has finished processing.</p>
@if($needsReview)<p>Some rows could not be priced. Their cost has been returned as account credits, and the downloaded results identify those rows.</p>@endif
<p><a href="{{ url('/list-upload/'.$uploadId) }}">Sign in to view and download your results</a></p>
