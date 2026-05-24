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
        Schema::create('cell_plantings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_cell_group_id')->nullable()->constrained('cell_groups')->nullOnDelete();
            $table->foreignId('new_cell_group_id')->nullable()->constrained('cell_groups')->nullOnDelete();
            $table->foreignId('leader_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('name');
            $table->string('target_neighborhood')->nullable();
            $table->string('target_city')->nullable();
            $table->date('planned_start_on')->nullable();
            $table->date('launched_on')->nullable();
            $table->string('status')->default('planning')->index();
            $table->unsignedInteger('initial_members_goal')->default(8);
            $table->text('strategy')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cell_plantings');
    }
};
