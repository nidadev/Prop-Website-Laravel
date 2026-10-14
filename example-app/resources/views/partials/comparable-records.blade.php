<section class="mt-4" aria-label="Comparable records">
<h2>Comparable records</h2>
<p>{{ $result['comparables']['note'] ?? 'This older valuation has no saved comparable breakdown.' }}</p>
<div class="table-responsive"><table class="table"><thead><tr><th>Property</th><th>Status</th><th>Price</th><th>Acres</th><th>Date</th><th>Distance</th><th>Source</th></tr></thead><tbody>
@forelse($result['comparables']['records'] ?? [] as $comp)
<tr><td>{{ $comp['address'] ?? $comp['id'] ?? 'Not supplied' }}</td><td>{{ $comp['status'] ?? 'Not supplied' }}</td><td>${{ number_format($comp['price'], 2) }}</td><td>{{ $comp['acres'] }}</td><td>{{ $comp['sold_date'] ?? $comp['observed_at'] ?? $comp['updated_date'] ?? 'Not supplied' }}</td><td>{{ isset($comp['distance_miles']) ? $comp['distance_miles'].' miles' : 'Not supplied' }}</td><td>@if(filter_var($comp['source_url'] ?? '', FILTER_VALIDATE_URL) && in_array(parse_url($comp['source_url'], PHP_URL_SCHEME), ['http', 'https']))<a href="{{ $comp['source_url'] }}" target="_blank" rel="noopener noreferrer">{{ $comp['source'] ?? 'View source' }}</a>@else{{ $comp['source'] ?? 'Not supplied' }}@endif</td></tr>
@empty<tr><td colspan="7">No matching comparable records available. Contact support for review.</td></tr>@endforelse
</tbody></table></div></section>
