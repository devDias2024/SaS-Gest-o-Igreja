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
        Schema::create('cell_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cell_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('host_member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->dateTime('starts_at')->index();
            $table->dateTime('ends_at')->nullable();
            $table->string('type')->default('meeting')->index();
            $table->string('theme')->nullable();
            $table->string('status')->default('scheduled')->index();
            $table->unsignedInteger('visitors_count')->default(0);
            $table->unsignedInteger('offerings_cents')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cell_meetings');
    }
};
