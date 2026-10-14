@extends('layouts.app2')
@section('content')
<main class="container py-5">
<h1>Administration</h1>
@if(session('error'))<p role="alert" class="alert alert-warning">{{ session('error') }}</p>@endif
@if(session('success'))<p role="status">{{ session('success') }}</p>@endif
@foreach($errors->all() as $error)<p role="alert">{{ $error }}</p>@endforeach
<div class="row">@foreach($stats as $label => $value)<div class="col-md-3"><h2 class="h5">{{ $label }}</h2><p>{{ $value }}</p></div>@endforeach</div>
<h2 class="mt-4">Users</h2>
@foreach($users as $user)
<form method="post" action="{{ url('/admin/users/'.$user->id) }}" class="row g-2 mb-3">@csrf
<div class="col-md-3"><label for="name-{{ $user->id }}">Name</label><input class="form-control" id="name-{{ $user->id }}" name="name" value="{{ $user->name }}" required></div>
<div class="col-md-4"><label for="email-{{ $user->id }}">Email</label><input class="form-control" id="email-{{ $user->id }}" name="email" type="email" value="{{ $user->email }}" required></div>
<div class="col-md-3"><label for="ban-{{ $user->id }}">Account status</label><select class="form-select" id="ban-{{ $user->id }}" name="is_banned"><option value="0" @selected(!$user->is_banned)>Allowed</option><option value="1" @selected($user->is_banned)>Suspended</option></select></div>
<div class="col-md-2 align-self-end"><button class="btn btn-primary">Save user</button></div></form>
@endforeach
{{ $users->links() }}
<h2 class="mt-4">Create user</h2>
<form method="post" action="{{ url('/admin/users') }}">@csrf
<label for="new-name">Name</label><input id="new-name" name="name" class="form-control" required>
<label for="new-email">Email</label><input id="new-email" name="email" type="email" class="form-control" required>
<label for="new-password">Initial password (12 characters minimum)</label><input id="new-password" name="password" type="password" autocomplete="new-password" minlength="12" class="form-control" required>
<button class="btn btn-primary mt-2">Create user</button></form>
<h2 class="mt-4">Pricing</h2>
<form method="post" action="{{ url('/admin/pricing') }}">@csrf
@foreach($plans as $key => $plan)<label for="plan-{{ $key }}">{{ $plan['name'] }} (USD per {{ $plan['interval'] }})</label><input class="form-control mb-2" id="plan-{{ $key }}" name="plan_{{ $key }}" type="number" step="0.01" min="1" value="{{ number_format($plan['amount']/100, 2, '.', '') }}" required>@endforeach
@foreach(config('pricing.services') as $key => $default)<label for="price-{{ $key }}">{{ ucwords(str_replace('_', ' ', $key)) }} (USD per record)</label><input class="form-control mb-2" id="price-{{ $key }}" name="service_{{ $key }}" type="number" step="0.01" min="0.01" value="{{ number_format(($settings['price_'.$key] ?? $default)/100, 2, '.', '') }}" required>@endforeach
<button class="btn btn-primary">Save prices</button></form>
<h2 class="mt-4">Comparable data import</h2>
<p>Upload the client-supplied monthly CSV. Required columns: state, county_fips, apn, property_type (land/house), status (sold/for_sale), price, source, source_url, observed_at (YYYY-MM-DD). Optional: acres, square_feet, address, city, latitude, longitude, sold_date. Invalid files are rejected without changing the dataset. Up to 25,000 records per file.</p>
<form method="post" action="{{ url('/admin/comparables/import') }}" enctype="multipart/form-data">@csrf<label for="comparable-file">Comparable CSV</label><input id="comparable-file" type="file" name="file" accept=".csv" class="form-control" required><label class="my-3"><input type="checkbox" name="data_rights" value="1" required> These records are supplied by the client or an authorized data source for use on Propelyze.</label><br><button class="btn btn-primary">Validate and import</button></form>
<h2 class="mt-4">Integration status</h2><div class="table-responsive"><table class="table"><tbody>
@foreach(['DataTree'=>config('property.datatree_enabled'), 'PRYCD'=>config('prycd.enabled') && config('prycd.key'), 'AI support'=>config('services.support_ai.enabled') && config('services.support_ai.key'), 'Registration CAPTCHA'=>config('services.recaptcha.enabled') && config('services.recaptcha.site_key') && config('services.recaptcha.secret')] as $label=>$enabled)<tr><th>{{ $label }}</th><td>{{ $enabled ? 'Configured — verify provider access' : 'Disabled / configuration required' }}</td></tr>@endforeach
<tr><th>Stripe</th><td>{{ str_starts_with(config('app.stripe_secret', ''), 'sk_test_') ? 'Test mode' : 'Live configuration — verify account activation' }}</td></tr>
<tr><th>Legacy subscribers needing reconciliation</th><td>{{ \App\Models\User::where('is_subscribed',1)->whereNotIn('id', \App\Models\BillingAccount::select('user_id'))->count() }}</td></tr>
<tr><th>Failed background jobs retained</th><td>{{ \Illuminate\Support\Facades\DB::table('failed_jobs')->count() }}</td></tr>
</tbody></table></div><p>Integration indicators show configuration only. No keys are displayed. Legacy subscription flags require provider confirmation before changing access.</p>
<h2 class="mt-4">Site details</h2>
<form method="post" action="{{ url('/admin/settings') }}">@csrf
@foreach(['contact_email' => 'Contact email', 'contact_phone' => 'Contact phone', 'contact_address' => 'Address', 'seo_title' => 'Page title', 'seo_description' => 'Search description', 'copyright' => 'Copyright text', 'map_embed_url' => 'Google Maps embed URL', 'coverage_embed_url' => 'Coverage Tableau Public embed URL', 'market_ratio_embed_url' => 'Parcels on market Tableau Public embed URL'] as $key => $label)
<label for="setting-{{ $key }}">{{ $label }}</label><input id="setting-{{ $key }}" name="{{ $key }}" class="form-control mb-2" value="{{ old($key, $settings[$key] ?? '') }}">
@endforeach
<label for="hero-image">Homepage image (existing img file)</label><input id="hero-image" name="hero_image" class="form-control mb-2" value="{{ old('hero_image', $settings['hero_image'] ?? 'img/1.jpg') }}">
<label for="youtube-video">How it works YouTube embed URL</label><input id="youtube-video" name="youtube_embed_url" class="form-control mb-2" value="{{ old('youtube_embed_url', $settings['youtube_embed_url'] ?? '') }}">
<label for="research-embed">Market research Tableau Public embed URL</label><input id="research-embed" name="research_embed_url" class="form-control mb-2" value="{{ old('research_embed_url', $settings['research_embed_url'] ?? '') }}">
<button class="btn btn-primary">Save site details</button></form>
</main>
@endsection
