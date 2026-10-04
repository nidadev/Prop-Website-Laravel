<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PricingCatalog
{
    public function plans(): array {
        $plans = config('pricing.plans');
        if (!Schema::hasTable('plan_price_versions')) { return $plans; }
        foreach (DB::table('plan_price_versions')->where('active', true)->get() as $version) {
            if (isset($plans[$version->plan])) { $plans[$version->plan]['amount'] = $version->amount; $plans[$version->plan]['version_id'] = $version->id; }
        }
        return $plans;
    }
    public function service(string $name): int {
        if ($name === 'land_report') { $name = 'comp_report'; }
        if (!Schema::hasTable('site_settings')) { return (int) config('pricing.services.'.$name); }
        return (int) (DB::table('site_settings')->where('key', 'price_'.$name)->value('value') ?? config('pricing.services.'.$name));
    }
}
