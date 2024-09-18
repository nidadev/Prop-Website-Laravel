<?php

use App\Console\Commands\DeleteCache;
use App\Console\Commands\InsertPropertyData;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(DeleteCache::class)->everyFiveSeconds();
Schedule::command(InsertPropertyData::class)->weekly();
