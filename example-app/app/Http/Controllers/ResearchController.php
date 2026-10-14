<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ResearchController extends Controller
{
    private function query(Request $request)
    {
        $data = $request->validate(['state' => ['nullable', Rule::in(array_keys(config('property.states')))],
            'county_fips' => ['nullable', 'regex:/^\d{5}$/'], 'property_type' => ['nullable', Rule::in(['land', 'house'])],
            'status' => ['nullable', Rule::in(['sold', 'for_sale'])], 'min_price' => 'nullable|numeric|min:0|max:9999999999999',
            'max_price' => 'nullable|numeric|min:0|max:9999999999999', 'observed_from' => 'nullable|date_format:Y-m-d|before_or_equal:today']);
        if (!empty($data['state']) && !empty($data['county_fips'])) {
            abort_unless((int) substr($data['county_fips'], 0, 2) === config('property.states.'.$data['state']), 422);
        }
        if (isset($data['min_price'], $data['max_price'])) { abort_unless($data['max_price'] >= $data['min_price'], 422); }
        $q = app(\App\Services\ResearchRecords::class)->queryForUser(auth()->id());
        foreach (['state', 'county_fips', 'property_type', 'status'] as $key) { if (!empty($data[$key])) { $q->where($key, $data[$key]); } }
        if (isset($data['min_price'])) { $q->where('price', '>=', $data['min_price']); }
        if (isset($data['max_price'])) { $q->where('price', '<=', $data['max_price']); }
        if (!empty($data['observed_from'])) { $q->where('observed_at', '>=', $data['observed_from']); }
        return $q;
    }

    public function index(Request $request)
    {
        $q = $this->query($request);
        $summary = (clone $q)->selectRaw('COUNT(*) as total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as sold, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as for_sale, MAX(observed_at) as updated', ['sold', 'for_sale'])->first();
        $records = $q->orderByDesc('observed_at')->orderBy('id')->paginate(30)->withQueryString();
        return view('research', compact('records', 'summary'));
    }

    public function download(Request $request)
    {
        $account = \App\Models\BillingAccount::where('user_id', auth()->id())->first();
        abort_unless(auth()->user()->usertype === 'admin' || ($account && $account->hasAccess() && in_array($account->plan, ['bronze_plus', 'gold'], true)), 403, 'Research exports require Bronze Plus or Gold.');
        $query = $this->query($request);
        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['state', 'county_fips', 'apn', 'listing_id', 'property_type', 'status', 'price', 'acres', 'square_feet', 'source', 'source_url', 'observed_at']);
            foreach ($query->orderBy('observed_at')->orderBy('id')->cursor() as $r) {
                $values = [$r->state, $r->county_fips, $r->apn, $r->listing_id, $r->property_type, $r->status, $r->price, $r->acres, $r->square_feet, $r->source, $r->source_url, $r->observed_at];
                fputcsv($out, array_map(fn ($v) => is_string($v) && preg_match('/^[=+@\-\t\r]/', $v) ? "'".$v : $v, $values));
            }
            fclose($out);
        }, 'propelyze-research.csv', ['Content-Type' => 'text/csv']);
    }
}
