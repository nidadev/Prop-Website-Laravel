<?php
namespace App\Http\Controllers;
use App\Services\OwnerPropertyData;
use App\Services\PropertyReportAnalysis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PropertyReportController extends Controller
{
    public function index()
    {
        return view('property-reports.index', ['reports' => DB::table('property_report_snapshots')->where('user_id', auth()->id())->latest()->paginate(20)]);
    }
    public function store(Request $request, OwnerPropertyData $provider, PropertyReportAnalysis $analysis)
    {
        $data = $request->validate([
            'kind' => ['required', Rule::in(['land', 'house'])], 'apn' => 'required|string|max:100',
            'county_fips' => ['required', Rule::in(array_map('strval', array_keys(config('counties'))))],
            'square_feet' => 'nullable|required_if:kind,house|numeric|min:1|max:1000000', 'acres' => 'nullable|numeric|min:0.00001|max:100000',
            'latitude' => 'nullable|required_with:longitude,radius_miles|numeric|between:-90,90',
            'longitude' => 'nullable|required_with:latitude,radius_miles|numeric|between:-180,180', 'radius_miles' => 'nullable|numeric|min:0.1|max:100',
            'lookback_days' => 'required|integer|min:1|max:365', 'offer_percent' => 'required|numeric|min:1|max:100',
            'min_price' => 'nullable|numeric|min:0|max:9999999999999', 'max_price' => 'nullable|numeric|min:0|max:9999999999999',
            'polygon' => 'nullable|string|max:10000',
        ]);
        $data = array_filter($data, fn ($value) => $value !== null && $value !== '');
        $data['apn'] = trim($data['apn']);
        if ($data['apn'] === '' || (isset($data['min_price'], $data['max_price']) && $data['min_price'] > $data['max_price'])) {
            throw ValidationException::withMessages(['apn' => 'Check the parcel identifier and price range.']);
        }
        if (isset($data['latitude']) && !\App\Services\PropertyCoordinates::pair($data['latitude'], $data['longitude'])) {
            throw ValidationException::withMessages(['latitude' => 'Enter a usable subject location.']);
        }
        $data['polygon'] = empty($data['polygon']) ? [] : json_decode($data['polygon'], true);
        if (!is_array($data['polygon']) || (count($data['polygon']) > 0 && (count($data['polygon']) < 3 || count($data['polygon']) > 100))) {
            throw ValidationException::withMessages(['polygon' => 'Draw a polygon with 3-100 points.']);
        }
        foreach ($data['polygon'] as $point) {
            if (!is_array($point) || count($point) !== 2 || !\App\Services\PropertyCoordinates::pair($point[0] ?? null, $point[1] ?? null)) {
                throw ValidationException::withMessages(['polygon' => 'The selected map area is invalid.']);
            }
        }
        if ($data['polygon'] && !$this->simplePolygon($data['polygon'])) {
            throw ValidationException::withMessages(['polygon' => 'Draw a non-overlapping polygon with a usable area.']);
        }
        $fingerprint = hash('sha256', json_encode($data));
        $existing = DB::table('property_report_snapshots')->where('user_id', auth()->id())->where('fingerprint', $fingerprint)->where('created_at', '>=', now()->subDays(30))->latest()->first();
        if ($existing) { return redirect('/property-reports/'.$existing->id); }
        try { $subject = $provider->fetch($data['apn'], $data['county_fips']); }
        catch (\Throwable $e) {
            \Log::warning('Owner property report unavailable', ['exception' => get_class($e)]);
            return back()->withInput()->with('error', 'Owner/property data is unavailable. No report was created or payment taken. Check the parcel or contact support.');
        }
        $result = ['subject' => $subject, 'analysis' => $analysis->analyze($data)];
        $id = DB::table('property_report_snapshots')->insertGetId(['user_id' => auth()->id(), 'kind' => $data['kind'], 'apn' => $data['apn'], 'county_fips' => $data['county_fips'],
            'fingerprint' => $fingerprint, 'filters' => json_encode($data), 'result' => json_encode($result), 'created_at' => now(), 'updated_at' => now()]);
        return redirect('/property-reports/'.$id);
    }
    private function simplePolygon(array $p): bool
    {
        $n = count($p); $area = 0;
        for ($i = 0; $i < $n; $i++) {
            $a = $p[$i]; $b = $p[($i + 1) % $n];
            if ($a == $b || abs($a[1] - $b[1]) > 180) { return false; }
            $area += $a[1] * $b[0] - $b[1] * $a[0];
            for ($j = $i + 2; $j < $n; $j++) {
                if ($i === 0 && $j === $n - 1) { continue; }
                $c = $p[$j]; $d = $p[($j + 1) % $n];
                $cross = fn ($u, $v, $w) => ($v[1]-$u[1])*($w[0]-$u[0])-($v[0]-$u[0])*($w[1]-$u[1]);
                if ($cross($a,$b,$c)*$cross($a,$b,$d) <= 0 && $cross($c,$d,$a)*$cross($c,$d,$b) <= 0
                    && max(min($a[0],$b[0]),min($c[0],$d[0])) <= min(max($a[0],$b[0]),max($c[0],$d[0]))
                    && max(min($a[1],$b[1]),min($c[1],$d[1])) <= min(max($a[1],$b[1]),max($c[1],$d[1]))) { return false; }
            }
        }
        return abs($area) > 1e-10;
    }
    private function owned(int $id): object
    {
        $report = DB::table('property_report_snapshots')->where('user_id', auth()->id())->where('id', $id)->first();
        abort_unless($report, 404); return $report;
    }
    private function data(object $report): array
    {
        $filters = json_decode($report->filters, true); $result = json_decode($report->result, true);
        return ['report' => $report, 'filters' => $filters, 'result' => $result,
            'locationMap' => app(\App\Services\PropertyReportMap::class)->image($filters, $result['analysis']['records'])];
    }
    private function paid(int $id): bool
    {
        return \App\Models\CheckoutOrder::where('user_id', auth()->id())->where('service', 'property_report')->where('status', 'paid')->get()
            ->contains(fn ($order) => in_array((string) $id, $order->property_ids, true));
    }
    public function show(int $id) { $report = $this->owned($id); return view('property-reports.show', $this->data($report) + ['paid' => $this->paid($id)]); }
    public function pdf(int $id)
    {
        $report = $this->owned($id); abort_unless($this->paid($id), 403, 'Purchase this report before downloading.');
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.property-report', $this->data($report))->setPaper('a4')->setOption('isRemoteEnabled', false)->download('propelyze-property-report-'.$id.'.pdf');
    }
    public function csv(int $id)
    {
        $report = $this->owned($id); abort_unless($this->paid($id), 403, 'Purchase this report before downloading.');
        $data = $this->data($report); $s = $data['result']['subject'];
        return response()->streamDownload(function () use ($data, $s) {
            $out = fopen('php://output', 'w');
            $write = fn ($row) => fputcsv($out, array_map(fn ($v) => is_string($v) && preg_match('/^[=+@\-\t\r]/', $v) ? "'".$v : $v, $row));
            $write(['record_type','apn','address','city','price','acres','square_feet','status','sold_date','observed_at','source','source_url','distance_miles','owner_name','mailing_address','mailing_city','mailing_state','mailing_zip','retrieved_at']);
            $write(['subject',$data['report']->apn,$s['address'],$s['city'],null,$data['filters']['acres']??null,$data['filters']['square_feet']??null,null,null,null,$s['source'],null,null,$s['owner_name'],$s['mailing_address'],$s['mailing_city'],$s['mailing_state'],$s['mailing_zip'],$s['retrieved_at']]);
            foreach ($data['result']['analysis']['records'] as $r) { $write(['comparable',$r['id'],$r['address'],$r['city'],$r['price'],$r['acres'],$r['square_feet'],$r['status'],$r['sold_date'],$r['observed_at'],$r['source'],$r['source_url'],$r['distance_miles'],null,null,null,null,null,null]); }
            fclose($out);
        }, 'propelyze-property-report-'.$id.'.csv', ['Content-Type' => 'text/csv', 'Cache-Control' => 'private, no-store']);
    }
    public function kml(int $id)
    {
        $report = $this->owned($id); abort_unless($this->paid($id), 403, 'Purchase this report before downloading.');
        $data = $this->data($report); $rows = $data['result']['analysis']['records'];
        if (isset($data['filters']['latitude'], $data['filters']['longitude'])) { array_unshift($rows, ['address' => 'Subject (user-entered location): '.$report->apn, 'latitude' => $data['filters']['latitude'], 'longitude' => $data['filters']['longitude'], 'source' => 'User-entered location']); }
        return response(app(\App\Services\ComparableKml::class)->render($rows, 'Propelyze property report '.$id), 200,
            ['Content-Type' => 'application/vnd.google-earth.kml+xml; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="propelyze-property-report-'.$id.'.kml"', 'Cache-Control' => 'private, no-store']);
    }
}
