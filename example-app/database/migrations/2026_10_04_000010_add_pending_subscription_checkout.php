<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('billing_accounts', function (Blueprint $table) {
            $table->string('checkout_attempt')->nullable();
            $table->string('checkout_session_id')->nullable();
            $table->string('checkout_plan')->nullable();
            $table->text('checkout_url')->nullable();
            $table->timestamp('checkout_expires_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('billing_accounts', fn (Blueprint $table) => $table->dropColumn([
            'checkout_attempt', 'checkout_session_id', 'checkout_plan', 'checkout_url', 'checkout_expires_at',
        ]));
    }
};
