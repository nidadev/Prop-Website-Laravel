<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'usertype')) { Schema::table('users', fn (Blueprint $t) => $t->string('usertype')->default('user')); }
        Schema::table('users', fn (Blueprint $t) => $t->boolean('is_banned')->default(false));
        Schema::create('site_settings', function (Blueprint $t) { $t->string('key')->primary(); $t->text('value')->nullable(); $t->timestamps(); });
    }
    public function down(): void {
        Schema::dropIfExists('site_settings');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn('is_banned'));
        // Preserve usertype: it may predate this migration in a production database.
    }
};
