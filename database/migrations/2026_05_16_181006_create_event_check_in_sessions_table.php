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
        Schema::create('event_check_in_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->constrained()->cascadeOnDelete();
            $table->string('token')->unique();
            $table->dateTime('expires_at')->index();
            $table->boolean('is_active')->default(true);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_check_in_sessions');
    }
};
