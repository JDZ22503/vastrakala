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
        Schema::create('referral_sharers', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->string('referral_code')->unique();
            $table->integer('target_count')->default(10);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        Schema::create('referral_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sharer_id')->constrained('referral_sharers')->onDelete('cascade');
            $table->string('guest_ip');
            $table->string('user_agent')->nullable();
            $table->timestamps();

            // Prevent same IP from clicking the same sharer link multiple times
            $table->unique(['sharer_id', 'guest_ip']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_visits');
        Schema::dropIfExists('referral_sharers');
    }
};
