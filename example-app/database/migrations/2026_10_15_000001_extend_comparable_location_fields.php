<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comparable_sales', function (Blueprint $t) {
            $t->string('address', 500)->nullable(); $t->string('city', 150)->nullable();
            $t->decimal('latitude', 10, 7)->nullable(); $t->decimal('longitude', 10, 7)->nullable();
            $t->date('sold_date')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('comparable_sales', fn (Blueprint $t) => $t->dropColumn(['address', 'city', 'latitude', 'longitude', 'sold_date']));
    }
};
