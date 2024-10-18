<?php

use App\Console\Commands\DeleteCache;
use App\Console\Commands\InsertPropertyData;
use App\Console\Commands\QueueWork;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(DeleteCache::class)->everyFiveMinutes();
Schedule::command(InsertPropertyData::class)->weekly();

Schedule::command('app:queue-work')->everyMinute();
/*Schedule::call(function (Schedule $schedule) {
    $schedule->command('app:queue-work');
    \Log::info('running');
})->daily();*/
