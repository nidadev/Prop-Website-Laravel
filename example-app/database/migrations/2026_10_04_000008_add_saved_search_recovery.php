<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('saved_searches', 'deleted_at')) {
            Schema::table('saved_searches', fn (Blueprint $table) => $table->softDeletes());
        }
    }
    public function down(): void { /* Preserve recovery timestamps when rolling back. */ }
};
