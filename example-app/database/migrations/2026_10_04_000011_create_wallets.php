<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('wallets', function (Blueprint $t) {
            $t->unsignedBigInteger('user_id')->primary(); $t->integer('balance')->default(0); $t->timestamps();
        });
        Schema::create('wallet_entries', function (Blueprint $t) {
            $t->id(); $t->unsignedBigInteger('user_id')->index(); $t->string('reference')->unique();
            $t->integer('amount'); $t->string('description'); $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('wallet_entries'); Schema::dropIfExists('wallets'); }
};
