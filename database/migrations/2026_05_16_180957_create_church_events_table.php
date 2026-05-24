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
        Schema::create('church_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_location_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('type')->default('service')->index();
            $table->text('description')->nullable();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at')->nullable();
            $table->string('recurrence_type')->default('none')->index();
            $table->unsignedInteger('recurrence_interval')->default(1);
            $table->json('recurrence_weekdays')->nullable();
            $table->date('recurrence_ends_on')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->boolean('requires_registration')->default(false);
            $table->boolean('registration_confirmation_required')->default(false);
            $table->dateTime('registration_starts_at')->nullable();
            $table->dateTime('registration_ends_at')->nullable();
            $table->string('check_in_token')->unique();
            $table->boolean('uses_dynamic_qr_code')->default(true);
            $table->boolean('allows_member_app_check_in')->default(true);
            $table->boolean('allows_offline_check_in')->default(true);
            $table->boolean('geofencing_enabled')->default(false);
            $table->unsignedInteger('reminder_hours_before')->nullable();
            $table->json('reminder_channels')->nullable();
            $table->string('status')->default('scheduled')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('church_events');
    }
};
