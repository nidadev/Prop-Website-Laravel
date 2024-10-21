<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StorageFileDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:storage-file-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $controller = new \App\Http\Controllers\Api\ApiController();
        $controller->deletefromStorage();

    }
}
