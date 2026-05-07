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
        Schema::table('referral_sharers', function (Blueprint $table) {
            $table->text('admin_note')->nullable()->after('is_used');
            $table->timestamp('used_at')->nullable()->after('admin_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_sharers', function (Blueprint $table) {
            $table->dropColumn(['admin_note', 'used_at']);
        });
    }
};
