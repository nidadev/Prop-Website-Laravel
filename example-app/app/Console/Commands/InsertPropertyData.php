<?php

namespace App\Console\Commands;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Console\Command;

class InsertPropertyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-property-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command will insert data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $controller = new \App\Http\Controllers\Api\ApiController();
        $controller->insert_prop_detail();
        $controller->insert_prop_detail2();
        $this->info('record inserted success');
    }
}
