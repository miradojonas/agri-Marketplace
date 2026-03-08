<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ussd_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('phone', 20);
            $table->foreignId('farmer_id')->nullable()->constrained()->onDelete('set null');
            $table->string('current_menu')->default('main');
            $table->json('session_data')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_interaction_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ussd_sessions');
    }
};
