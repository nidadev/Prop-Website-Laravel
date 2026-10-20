<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('plan_price_versions', function (Blueprint $t) {
            $t->id(); $t->string('plan'); $t->unsignedInteger('amount'); $t->string('interval'); $t->boolean('active'); $t->timestamps();
            $t->unique(['plan', 'amount', 'interval']);
        });
        foreach (config('pricing.plans') as $key => $plan) {
            DB::table('plan_price_versions')->insert(['plan' => $key, 'amount' => $plan['amount'], 'interval' => $plan['interval'], 'active' => true, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
    public function down(): void { Schema::dropIfExists('plan_price_versions'); }
};
