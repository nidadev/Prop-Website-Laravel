<!doctype html><html><head><meta charset="utf-8"><style>body{font-family:DejaVu Sans,sans-serif;font-size:11px;color:#173047}h1{font-size:24px}h2{font-size:18px;color:#087c76}table{width:100%;border-collapse:collapse}td{padding:12px;border-bottom:1px solid #ddd}.muted{color:#555;line-height:1.6}</style></head><body>
<h1>Propelyze land valuation</h1><p>Report {{ $valuation->id }} · APN {{ $valuation->apn }} · County FIPS {{ $valuation->county_fips }}</p>
<h2>Estimated market value: ${{ number_format($result['market_value'],2) }}</h2>
<table><tr><td>Price per acre</td><td>{{ isset($result['price_per_acre']) ? '$'.number_format($result['price_per_acre'],2) : 'Not supplied' }}</td></tr>
<tr><td>Acreage</td><td>{{ $result['acres'] ?? 'Not supplied' }}</td></tr><tr><td>Source / model</td><td>{{ $result['source'] }} / {{ $result['model'] ?? 'Not supplied' }}</td></tr>
<tr><td>Provider confidence</td><td>{{ $result['confidence'] ?? 'Not supplied' }}</td></tr><tr><td>Data retrieved</td><td>{{ $result['retrieved_at'] }}</td></tr></table>
@include('partials.comparable-records')
<h2>Before making an offer</h2><p class="muted">Confirm parcel identity and boundaries, legal road access, zoning, utilities, terrain, flood risk, development constraints, title, and recent comparable sales. This automated valuation is not an appraisal and does not include verified owner details or a house valuation.</p>
<p class="muted">Questions? support@propelyze.com</p></body></html>
