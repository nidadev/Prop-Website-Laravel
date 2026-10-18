<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void { Schema::create('property_report_snapshots', function (Blueprint $t) {
        $t->id(); $t->unsignedBigInteger('user_id')->index(); $t->string('kind', 10); $t->string('apn', 100); $t->string('county_fips', 5);
        $t->string('fingerprint', 64)->index(); $t->json('filters'); $t->json('result'); $t->timestamps();
    }); }
    public function down(): void { Schema::dropIfExists('property_report_snapshots'); }
};
