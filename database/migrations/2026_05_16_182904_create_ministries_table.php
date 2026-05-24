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
        Schema::create('ministries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('name')->unique();
            $table->string('type')->default('ministry')->index();
            $table->string('status')->default('active')->index();
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
        Schema::dropIfExists('ministries');
    }
};
