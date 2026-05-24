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
        Schema::create('event_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('event_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guest_name')->nullable();
            $table->string('method')->default('manual')->index();
            $table->dateTime('checked_in_at')->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('inside_geofence')->nullable();
            $table->string('device_id')->nullable();
            $table->string('qr_token')->nullable()->index();
            $table->boolean('synced_from_offline')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['church_event_id', 'checked_in_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_check_ins');
    }
};
