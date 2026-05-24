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
        Schema::create('communication_automations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('trigger');
            $table->json('channels');
            $table->json('conditions')->nullable();
            $table->unsignedInteger('delay_minutes')->default(0);
            $table->string('status')->default('active');
            $table->timestamp('last_run_at')->nullable();
            $table->unsignedInteger('run_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_automations');
    }
};
