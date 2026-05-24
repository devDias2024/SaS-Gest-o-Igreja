<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('preventive')->index();
            $table->string('status')->default('scheduled')->index();
            $table->date('scheduled_at')->nullable()->index();
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable()->index();
            $table->decimal('cost', 12, 2)->default(0);
            $table->string('provider')->nullable();
            $table->text('description')->nullable();
            $table->text('result')->nullable();
            $table->date('next_maintenance_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
    }
};
