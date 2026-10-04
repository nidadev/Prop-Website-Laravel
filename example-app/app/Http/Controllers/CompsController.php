<?php
namespace App\Http\Controllers;
use App\Services\PrycdClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CompsController extends Controller {
    public function index() { return view('land-comps', ['searches' => DB::table('comp_searches')->where('user_id', auth()->id())->latest()->paginate(20)]); }
    public function store(Request $request, PrycdClient $client) {
        $input = $request->validate(['state' => 'required|string|max:100', 'county' => 'required|string|max:100',
            'min_acres' => 'required|numeric|min:0|max:100000', 'max_acres' => 'required|numeric|gte:min_acres|max:100000']);
        try { $results = $client->countyComps($input['state'], $input['county'], $input['min_acres'], $input['max_acres']); }
        catch (\Throwable $error) { return back()->withInput()->with('error', 'Comparable data is unavailable for this request. Check the county and acreage range, or contact support.'); }
        $id = DB::table('comp_searches')->insertGetId(['user_id' => auth()->id(), 'filters' => json_encode($input),
            'results' => json_encode($results), 'created_at' => now(), 'updated_at' => now()]);
        return redirect('/land-comps/'.$id);
    }
    private function owned(int $id): object {
        $search = DB::table('comp_searches')->where('user_id', auth()->id())->where('id', $id)->first(); abort_unless($search, 404); return $search;
    }
    public function show(int $id) {
        $search = $this->owned($id); $filters = json_decode($search->filters, true); $results = json_decode($search->results, true);
        return view('land-comps-detail', compact('search', 'filters', 'results'));
    }
    public function download(int $id) {
        $search = $this->owned($id); $account = \App\Models\BillingAccount::where('user_id', auth()->id())->first();
        abort_unless(auth()->user()->usertype === 'admin' || ($account && $account->hasAccess() && in_array($account->plan, ['bronze_plus','gold'], true)), 403, 'Comparable exports require Bronze Plus or Gold.');
        return response()->streamDownload(function () use ($search) {
            $out = fopen('php://output','w'); fputcsv($out,['address','city','price','acres','price_per_acre','status','source','source_url','sold_date','updated_date','latitude','longitude']);
            foreach (json_decode($search->results,true) as $row) {
                $values = [$row['address'], $row['city'], $row['price'], $row['acres'], $row['price']/$row['acres'], $row['status'], $row['source'], $row['source_url'], $row['sold_date'], $row['updated_date'], $row['latitude'], $row['longitude']];
                fputcsv($out,array_map(fn ($v) => is_string($v) && preg_match('/^[=+@\-\t\r]/',$v) ? "'".$v : $v,$values));
            } fclose($out);
        },'propelyze-land-comps-'.$id.'.csv',['Content-Type'=>'text/csv']);
    }
}
