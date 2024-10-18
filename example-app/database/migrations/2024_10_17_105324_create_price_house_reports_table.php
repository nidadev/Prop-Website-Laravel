<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('price_house_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->string('state');
            $table->string('county_name');
            $table->json('sts'); // Store the fetched data as JSON
            $table->json('de');
           // $table->json('data');
            $table->json('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_house_reports');
    }
};
