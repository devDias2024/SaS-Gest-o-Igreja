<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_age_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('min_age_months')->default(0);
            $table->unsignedSmallInteger('max_age_months')->nullable();
            $table->string('location')->nullable();
            $table->unsignedSmallInteger('capacity')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_age_groups');
    }
};
