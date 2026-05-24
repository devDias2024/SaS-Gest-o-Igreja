<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_emergency_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('child_check_in_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('child_guardian_id')->nullable()->constrained()->nullOnDelete();
            $table->string('channel')->default('sms');
            $table->string('recipient_phone')->nullable();
            $table->text('message');
            $table->string('status')->default('pending')->index();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_emergency_calls');
    }
};
