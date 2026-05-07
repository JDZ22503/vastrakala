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
            $table->string('browser_id')->unique()->nullable()->after('id');
            // Remove the unique constraint from ip_address or make it nullable because 
            // the same IP might have a different browser_id later
            $table->dropUnique(['ip_address']);
            $table->string('ip_address')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referral_sharers', function (Blueprint $table) {
            $table->dropColumn('browser_id');
            $table->string('ip_address')->unique()->change();
        });
    }
};
