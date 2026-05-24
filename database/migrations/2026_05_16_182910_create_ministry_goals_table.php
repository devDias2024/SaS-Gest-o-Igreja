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
        Schema::create('ministry_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ministry_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('cell_group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('metric')->default('members')->index();
            $table->decimal('target_value', 12, 2);
            $table->decimal('current_value', 12, 2)->default(0);
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->string('status')->default('active')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ministry_goals');
    }
};
