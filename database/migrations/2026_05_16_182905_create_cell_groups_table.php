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
        Schema::create('cell_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('leader_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('name')->unique();
            $table->string('status')->default('active')->index();
            $table->string('meeting_day')->nullable();
            $table->time('meeting_time')->nullable();
            $table->string('host_name')->nullable();
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->string('state', 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->date('started_on')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cell_groups');
    }
};
