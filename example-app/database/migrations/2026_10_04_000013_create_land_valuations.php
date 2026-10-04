<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('land_valuations', function (Blueprint $t) {
        $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete(); $t->string('apn', 100);
        $t->string('county_fips', 5); $t->json('result'); $t->timestamps(); $t->index(['user_id', 'apn', 'county_fips']);
    }); }
    public function down(): void { Schema::dropIfExists('land_valuations'); }
};
