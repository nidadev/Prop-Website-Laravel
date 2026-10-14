<?php
namespace App\Http\Controllers;
use App\Services\PrycdClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LandValuationController extends Controller {
    public function index() {
        return view('land-valuation', ['valuations' => DB::table('land_valuations')->where('user_id', auth()->id())->latest()->paginate(20)]);
    }
    public function store(Request $request, PrycdClient $client) {
        $input = $request->validate(['apn' => 'required|string|max:100', 'county_fips' => 'required|regex:/^\d{5}$/']);
        $existing = DB::table('land_valuations')->where('user_id', auth()->id())->where('apn', $input['apn'])->where('county_fips', $input['county_fips'])->where('created_at', '>', now()->subDays(30))->latest()->first();
        if ($existing) { return redirect('/land-valuation/'.$existing->id); }
        try { $result = $client->priceLand($input['apn'], $input['county_fips']);
            $result['comparables'] = app(\App\Services\ComparableRecords::class)->forParcel($input['apn'], $input['county_fips'], $result, $client); }
        catch (\Throwable $error) { return back()->withInput()->with('error', 'No verified valuation is available right now. Check the parcel details or contact support. No report payment has been taken.'); }
        $id = DB::table('land_valuations')->insertGetId($input + ['user_id' => auth()->id(), 'result' => json_encode($result), 'created_at' => now(), 'updated_at' => now()]);
        return redirect('/land-valuation/'.$id);
    }
    private function owned(int $id): object {
        $row = DB::table('land_valuations')->where('user_id', auth()->id())->where('id', $id)->first(); abort_unless($row, 404); return $row;
    }
    public function show(int $id) {
        $valuation = $this->owned($id); $result = json_decode($valuation->result, true);
        $paid = \App\Models\CheckoutOrder::where('user_id', auth()->id())->where('service', 'land_report')->where('status', 'paid')->get()->contains(fn ($order) => in_array((string) $id, $order->property_ids, true));
        return view('land-valuation-detail', compact('valuation', 'result', 'paid'));
    }
    public function pdf(int $id) {
        $valuation = $this->owned($id); $result = json_decode($valuation->result, true);
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.land-valuation', compact('valuation', 'result'))
            ->setOption('isRemoteEnabled', false)->download('propelyze-land-report-'.$id.'.pdf');
    }
}
