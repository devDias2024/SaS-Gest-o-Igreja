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
        Schema::create('offline_check_in_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->nullable()->constrained()->nullOnDelete();
            $table->string('device_id')->nullable()->index();
            $table->string('uploaded_by')->nullable();
            $table->json('payload');
            $table->unsignedInteger('records_count')->default(0);
            $table->unsignedInteger('processed_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->string('status')->default('pending')->index();
            $table->timestamp('processed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offline_check_in_batches');
    }
};
