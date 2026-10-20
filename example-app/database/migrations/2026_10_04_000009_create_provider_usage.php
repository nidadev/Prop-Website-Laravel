<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('provider_usage', function (Blueprint $table) {
            $table->id(); $table->string('service'); $table->string('period',7);
            $table->unsignedInteger('requests')->default(0); $table->timestamps();
            $table->unique(['service','period']);
        });
        Schema::create('provider_responses', function (Blueprint $table) {
            $table->string('cache_key',64)->primary(); $table->longText('payload');
            $table->timestamp('expires_at'); $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('provider_responses'); Schema::dropIfExists('provider_usage'); }
};
