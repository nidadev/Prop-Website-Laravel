<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SavedSearchController extends Controller
{
    public function index() {
        $searches = DB::table('saved_searches')->where('user_id', auth()->id())->whereNull('deleted_at')->latest()->get();
        return view('saved-searches', compact('searches'));
    }
    public function store(Request $request) {
        $request->validate(['kind' => ['required', Rule::in(['land', 'house'])], 'search_name' => 'nullable|string|max:100']);
        $house = $request->kind === 'house';
        $suffix = $house ? '1' : '';
        $values = ['state' => $request->input('state'.$suffix), 'county_name' => $request->input('county_name'.$suffix), 'cp' => $request->input('cp'.$suffix)];
        $data = validator($values, ['state' => ['required', Rule::in(array_keys(config('property.states')))],
            'county_name' => 'required|string|max:100', 'cp' => ['required', 'regex:/^\d{5}$/']])->validate();
        abort_unless((int) substr($data['cp'], 0, 2) === config('property.states.'.$data['state']), 422);
        DB::table('saved_searches')->insert(['user_id' => auth()->id(), 'kind' => $request->kind,
            'name' => $request->search_name ?: $data['county_name'].', '.strtoupper($data['state']),
            'filters' => json_encode($data), 'created_at' => now(), 'updated_at' => now()]);
        return redirect('/saved-searches')->with('success', 'Search saved.');
    }
    public function run(Request $request, int $id) {
        $search = $this->owned($id);
        $filters = json_decode($search->filters, true);
        if ($search->kind === 'house') {
            $request->merge(['state1' => $filters['state'], 'county_name1' => $filters['county_name'], 'cp1' => $filters['cp']]);
            return app(ApiController::class)->GetPriceHouseReport($request);
        }
        $request->merge($filters);
        return app(ApiController::class)->GetPriceReport($request);
    }
    public function remove(int $id) {
        $search = $this->owned($id);
        DB::table('saved_searches')->where('id', $search->id)->update(['deleted_at' => now(), 'updated_at' => now()]);
        return back()->with('success', 'Search removed.')->with('restore_search', $search->id);
    }
    public function restore(int $id) {
        $search = DB::table('saved_searches')->where('user_id', auth()->id())->where('id', $id)->first(); abort_unless($search, 404);
        DB::table('saved_searches')->where('id', $id)->update(['deleted_at' => null, 'updated_at' => now()]);
        return redirect('/saved-searches')->with('success', 'Search restored.');
    }
    private function owned(int $id) {
        $search = DB::table('saved_searches')->where('user_id', auth()->id())->where('id', $id)->whereNull('deleted_at')->first(); abort_unless($search, 404);
        return $search;
    }
}
