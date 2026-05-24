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
        Schema::create('event_volunteer_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('volunteer_role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('slot_number')->default(1);
            $table->string('status')->default('scheduled')->index();
            $table->boolean('auto_assigned')->default(false);
            $table->timestamp('notified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['church_event_id', 'volunteer_role_id', 'member_id', 'slot_number'], 'event_volunteer_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_volunteer_assignments');
    }
};
