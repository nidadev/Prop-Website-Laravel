<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('checkout_orders', function (Blueprint $t) {
            $t->foreignId('list_upload_id')->nullable()->constrained('list_uploads');
        });
        Schema::create('report_credit_grants', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('month', 7); $t->unsignedInteger('credits'); $t->timestamps();
            $t->unique(['user_id', 'month']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('report_credit_grants');
        Schema::table('checkout_orders', function (Blueprint $t) { $t->dropConstrainedForeignId('list_upload_id'); });
    }
};
