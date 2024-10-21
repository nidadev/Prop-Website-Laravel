<?php

namespace App\Jobs;

use App\Models\Export;
use Illuminate\Bus\Queueable;
use App\Exports\PriceHouseExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\ExportCompleted;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class ExportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userIds;
    protected $user;

    public function __construct(array $userIds,$user)
    {
        $this->userIds = $userIds;
        $this->user = $user;
    }
    public function maxAttempts()
    {
        return 5; // Set your desired number of attempts
    }
    public function handle()
    {
        try {
        //dd($this->userIds);
        $fileName = 'price_house_export_' . now()->format('Ymd_His') . '.xlsx';
        Excel::store(new PriceHouseExport($this->userIds), $fileName, 'public');
        // Store export information in the database
        Export::create([
            'user_id' => $this->user->id,
            'file_name' => $fileName,
            'status' => 'completed', // Update status
        ]);

        // Notify the user that the export is complete
        //$this->user->notify(new ExportCompleted($fileName));
        $user = $this->user; // or however you retrieve the user
    Notification::send($user, new ExportCompleted($fileName));
    DB::table('exports')
        ->where('file_name', $fileName)
        ->update(['downloaded' => 1]);
    //Mail::to('nidahafeez@outlook.com')->send(new ExportCompleted($fileName));
        }
        catch (\Exception $e) {
            // Log the exception
            \Log::error('ExportDataJob failed: ' . $e->getMessage());
    
            // Optionally throw the exception to trigger a retry
            throw $e;
        }
    //Mail::to('nidahafeez@outlook.com')->send(new ExportCompleted($fileName));
    
    }
}
