<?php

namespace App\Http\Controllers;

use App\Services\ApnListReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListUploadController extends Controller
{
    public function index()
    {
        return view('list-upload', ['uploads' => DB::table('list_uploads')->where('user_id', auth()->id())->latest()->get()]);
    }
    public function store(Request $request, ApnListReader $reader)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx|max:10240']);
        $file = $request->file('file');
        $rows = $reader->read($file->getRealPath(), $file->getClientOriginalExtension());
        $id = DB::transaction(function () use ($rows) {
            $id = DB::table('list_uploads')->insertGetId(['user_id' => auth()->id(), 'record_count' => count($rows), 'created_at' => now(), 'updated_at' => now()]);
            foreach (array_chunk($rows, 500) as $chunk) {
                DB::table('list_upload_rows')->insert(array_map(fn ($row) => $row + ['list_upload_id' => $id, 'created_at' => now(), 'updated_at' => now()], $chunk));
            }
            return $id;
        });
        return redirect('/list-upload/'.$id)->with('success', count($rows).' unique APN records are ready for pricing.');
    }
    public function show(int $id)
    {
        $upload = DB::table('list_uploads')->where('user_id', auth()->id())->where('id', $id)->first(); abort_unless($upload, 404);
        $rows = DB::table('list_upload_rows')->where('list_upload_id', $id)->paginate(50);
        return view('list-upload-detail', compact('upload', 'rows'));
    }

    public function download(int $id)
    {
        $upload = DB::table('list_uploads')->where('user_id', auth()->id())->where('id', $id)->first(); abort_unless($upload, 404);
        abort_unless(in_array($upload->status, ['completed', 'completed_with_issues'], true), 422);
        return response()->streamDownload(function () use ($id) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['state', 'county_fips', 'apn', 'status', 'market_value', 'price_per_acre', 'source', 'confidence', 'retrieved_at', 'review_note']);
            foreach (DB::table('list_upload_rows')->where('list_upload_id', $id)->orderBy('id')->lazyById(100) as $row) {
                $result = json_decode($row->result ?? '{}', true);
                $values = [$row->state, $row->county_fips, $row->apn, $row->status, $result['market_value'] ?? '',
                    $result['price_per_acre'] ?? '', $result['source'] ?? '', $result['confidence'] ?? '', $result['retrieved_at'] ?? '', $row->error ?? ''];
                fputcsv($out, array_map(fn ($value) => is_string($value) && preg_match('/^[=+@\-\t\r]/', $value) ? "'".$value : $value, $values));
            }
            fclose($out);
        }, 'propelyze-list-'.$id.'.csv', ['Content-Type' => 'text/csv']);
    }
}
