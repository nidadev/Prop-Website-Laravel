<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comp_searches', fn (Blueprint $t) => $t->timestamp('research_indexed_at')->nullable());
        Schema::create('provider_research_records', function (Blueprint $t) {
            $t->id(); $t->foreignId('comp_search_id')->constrained('comp_searches')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete(); $t->string('source_key', 64);
            $t->string('state', 2); $t->string('county_fips', 5); $t->string('apn', 100)->nullable();
            $t->string('listing_id', 255)->nullable(); $t->string('property_type')->default('land');
            $t->string('status'); $t->decimal('price', 15, 2); $t->decimal('acres', 15, 5)->nullable();
            $t->decimal('square_feet', 15, 2)->nullable(); $t->string('source'); $t->text('source_url');
            $t->date('observed_at'); $t->timestamps();
            $t->unique(['comp_search_id', 'source_key']); $t->index(['user_id', 'state', 'county_fips']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('provider_research_records');
        Schema::table('comp_searches', fn (Blueprint $t) => $t->dropColumn('research_indexed_at'));
    }
};
