<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('stripe_catalog', function (Blueprint $t) {
            $t->id(); $t->unsignedBigInteger('version_id'); $t->string('account_key', 64);
            $t->string('product_id'); $t->string('price_id')->unique(); $t->timestamps();
            $t->unique(['version_id', 'account_key']);
        });
    }
    public function down(): void { Schema::dropIfExists('stripe_catalog'); }
};
