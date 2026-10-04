<?php
namespace App\Http\Controllers;
use App\Services\PrycdClient;
use Illuminate\Http\Request;
class PropertyApiController extends Controller {
    public function price(Request $request, PrycdClient $client) {
        $data=$request->validate(['apn'=>'required|string|max:100','county_fips'=>'required|regex:/^\d{5}$/']);
        try { return response()->json(['data'=>$client->priceLand($data['apn'],$data['county_fips'])]); }
        catch (\Throwable $error) { return response()->json(['message'=>'A verified land valuation is currently unavailable. Check the parcel details and data allowance.'],503); }
    }
    public function comps(Request $request, PrycdClient $client) {
        $data=$request->validate(['state'=>'required|string|max:100','county'=>'required|string|max:100',
            'min_acres'=>'required|numeric|min:0|max:100000','max_acres'=>'required|numeric|gte:min_acres|max:100000']);
        try { return response()->json(['data'=>$client->countyComps($data['state'],$data['county'],$data['min_acres'],$data['max_acres'])]); }
        catch (\Throwable $error) { return response()->json(['message'=>'Comparable data is currently unavailable. Check the location and data allowance.'],503); }
    }
}
