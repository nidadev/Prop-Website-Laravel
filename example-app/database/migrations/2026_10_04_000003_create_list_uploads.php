<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('list_uploads', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('status')->default('awaiting_payment'); $t->unsignedInteger('record_count'); $t->timestamps();
        });
        Schema::create('list_upload_rows', function (Blueprint $t) {
            $t->id(); $t->foreignId('list_upload_id')->constrained()->cascadeOnDelete();
            $t->string('state', 2); $t->string('county_fips', 5); $t->string('apn', 100);
            $t->string('status')->default('pending'); $t->json('result')->nullable(); $t->string('error')->nullable(); $t->timestamps();
        });
        Schema::create('comparable_sales', function (Blueprint $t) {
            $t->id(); $t->string('state', 2); $t->string('county_fips', 5); $t->string('apn', 100);
            $t->string('property_type'); $t->string('status'); $t->decimal('price', 15, 2);
            $t->decimal('acres', 15, 5)->nullable(); $t->decimal('square_feet', 15, 2)->nullable();
            $t->string('source'); $t->text('source_url'); $t->date('observed_at'); $t->timestamps();
            $t->index(['state', 'county_fips', 'property_type', 'status']);
            $t->unique(['state', 'county_fips', 'apn', 'source', 'status', 'observed_at'], 'comparable_identity');
        });
        Schema::create('saved_searches', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name'); $t->string('kind'); $t->json('filters'); $t->timestamps(); $t->softDeletes();
        });
    }
    public function down(): void
    {
        foreach (['saved_searches', 'comparable_sales', 'list_upload_rows', 'list_uploads'] as $table) { Schema::dropIfExists($table); }
    }
};
