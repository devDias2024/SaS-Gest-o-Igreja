<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastoral_counseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pastoral_counseling_case_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pastor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('scheduled_at')->index();
            $table->unsignedSmallInteger('duration_minutes')->default(60);
            $table->string('location_type')->default('in_person')->index();
            $table->string('location')->nullable();
            $table->string('meeting_url')->nullable();
            $table->string('status')->default('scheduled')->index();
            $table->timestamp('reminder_at')->nullable();
            $table->timestamp('reminder_sent_at')->nullable();
            $table->text('confidential_notes')->nullable();
            $table->text('next_steps')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_counseling_sessions');
    }
};
