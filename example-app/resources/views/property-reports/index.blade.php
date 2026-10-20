@extends('layouts.app2')
@section('content')
<main class="container-xl py-5 content-prose"><h1>Owner and house reports</h1>
<p>Retrieve owner/property details by APN and compare recent client-supplied sales in the same county. House analysis uses the living area you enter; it is not a house AVM.</p>
@if(!config('property.datatree_enabled'))<p class="alert alert-warning">New owner/property reports are temporarily unavailable until DataTree access is restored. Your saved reports remain available.</p>@endif
@if(session('error'))<p class="alert alert-warning" role="alert">{{ session('error') }}</p>@endif
@foreach($errors->all() as $error)<p class="alert alert-warning">{{ $error }}</p>@endforeach
<form method="post" action="{{ url('/property-reports') }}" class="row g-3">@csrf
<div class="col-md-4"><label for="report-kind">Property type</label><select id="report-kind" name="kind" class="form-select">@foreach(['house'=>'House','land'=>'Land'] as $value=>$label)<option value="{{ $value }}" @selected(old('kind','house') === $value)>{{ $label }}</option>@endforeach</select></div>
<div class="col-md-4"><label for="report-apn">Parcel APN</label><input id="report-apn" name="apn" class="form-control" required maxlength="100" value="{{ old('apn') }}"></div>
<div class="col-md-4"><label for="report-county">County</label><select id="report-county" name="county_fips" class="form-select" required><option value="">Select county</option>@foreach(config('counties') as $fips=>$county)<option value="{{ $fips }}" @selected((string)old('county_fips') === (string)$fips)>{{ $county['state_name'] }} - {{ $county['name'] }} ({{ $fips }})</option>@endforeach</select></div>
<div class="col-md-6"><label for="report-sqft">Subject living area (sq ft, required for houses)</label><input id="report-sqft" name="square_feet" type="number" min="1" max="1000000" step="any" class="form-control" value="{{ old('square_feet') }}"></div>
<div class="col-md-6"><label for="report-acres">Subject land area (acres, optional)</label><input id="report-acres" name="acres" type="number" min="0.00001" max="100000" step="any" class="form-control" value="{{ old('acres') }}"></div>
<div class="col-12"><p class="small">Subject size and coordinates are user-entered inputs, not provider-verified measurements. Keep APNs as printed in the county record.</p></div>
<div class="col-md-6"><label for="report-days">Recent sales and observations (days)</label><input id="report-days" name="lookback_days" type="number" min="1" max="365" value="{{ old('lookback_days',90) }}" required class="form-control"></div>
<div class="col-md-6"><label for="report-offer">Offer scenario (% of indicative estimate)</label><input id="report-offer" name="offer_percent" type="number" min="1" max="100" step="any" value="{{ old('offer_percent',70) }}" required class="form-control"></div>
<div class="col-12"><details id="advanced-report-filters"><summary>Advanced comparable filters</summary><div class="row g-3 mt-1">
@foreach(['min_price'=>'Minimum comparable price ($)','max_price'=>'Maximum comparable price ($)','latitude'=>'Subject latitude (optional)','longitude'=>'Subject longitude (optional)','radius_miles'=>'Maximum distance (miles, needs subject coordinates)'] as $key=>$label)
<div class="col-md-6"><label for="report-{{ $key }}">{{ $label }}</label><input id="report-{{ $key }}" name="{{ $key }}" type="number" step="any" value="{{ old($key) }}" class="form-control"></div>@endforeach
<div class="col-12"><p>Optional map area: click Start drawing, click at least three corners on the map, then Finish. Only comparable locations inside this area will be used. This does not discover owner records or parcel boundaries.</p><button type="button" class="btn btn-outline-primary" id="area-start">Start drawing</button> <button type="button" class="btn btn-outline-primary" id="area-finish">Finish</button> <button type="button" class="btn btn-outline-secondary" id="area-clear">Clear area</button><p id="area-status" role="status" class="small mt-2"></p><div id="report-area-map" style="height:350px"></div><input type="hidden" id="report-polygon" name="polygon" value="{{ old('polygon') }}"></div>
</div></details></div>
<div class="col-12"><button class="btn btn-primary" @disabled(!config('property.datatree_enabled'))>Generate report preview</button><p class="small mt-2">No report payment is taken here. PDF, CSV and KML downloads cost ${{ number_format(app(\App\Services\PricingCatalog::class)->service('property_report')/100,2) }} per report or one available Gold report credit. Check the preview and coverage before purchasing.</p></div>
</form>
<h2 class="mt-5">Your saved reports</h2><div class="table-responsive"><table class="table"><thead><tr><th>APN</th><th>Type</th><th>County</th><th>Saved</th><th></th></tr></thead><tbody>@forelse($reports as $report)<tr><td>{{ $report->apn }}</td><td>{{ ucfirst($report->kind) }}</td><td>{{ $report->county_fips }}</td><td>{{ $report->created_at }}</td><td><a href="{{ url('/property-reports/'.$report->id) }}">View report</a></td></tr>@empty<tr><td colspan="5">No owner/property reports saved yet.</td></tr>@endforelse</tbody></table></div>{{ $reports->links() }}</main>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="anonymous">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin="anonymous"></script>
<script>
const areaMap=L.map('report-area-map',{scrollWheelZoom:false}).setView([39,-98],4);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18,attribution:'&copy; OpenStreetMap contributors'}).addTo(areaMap);
const polygonInput=document.getElementById('report-polygon'),areaStatus=document.getElementById('area-status');let areaPoints=[],areaDrawing=false,areaLayer;
try{const restored=JSON.parse(polygonInput.value||'[]');if(Array.isArray(restored)&&restored.every(p=>Array.isArray(p)&&p.length===2&&p.every(Number.isFinite)))areaPoints=restored;}catch(e){}
function drawArea(){if(areaLayer)areaMap.removeLayer(areaLayer);if(areaPoints.length)areaLayer=L.polygon(areaPoints,{color:'#6c5cff'}).addTo(areaMap);polygonInput.value=areaPoints.length?JSON.stringify(areaPoints):'';areaStatus.textContent=areaPoints.length+' points selected'+(areaDrawing?' - drawing':'');}
drawArea();if(areaPoints.length)areaMap.fitBounds(areaPoints);
document.getElementById('area-start').onclick=()=>{areaPoints=[];areaDrawing=true;drawArea();areaMap.invalidateSize();};
document.getElementById('area-finish').onclick=()=>{if(areaPoints.length<3){areaStatus.textContent='Select at least three corners.';return;}areaDrawing=false;drawArea();};
document.getElementById('area-clear').onclick=()=>{areaPoints=[];areaDrawing=false;drawArea();};
areaMap.on('click',e=>{if(areaDrawing&&areaPoints.length<100){areaPoints.push([e.latlng.lat,e.latlng.lng]);drawArea();}});
document.getElementById('advanced-report-filters').addEventListener('toggle',()=>setTimeout(()=>areaMap.invalidateSize(),50));
</script>
@endsection
