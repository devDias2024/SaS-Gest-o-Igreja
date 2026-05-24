<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('name');
            $table->string('course_name')->nullable();
            $table->string('period_label')->nullable();
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->string('schedule')->nullable();
            $table->string('room')->nullable();
            $table->string('status')->default('active')->index();
            $table->unsignedTinyInteger('minimum_attendance_percent')->default(75);
            $table->decimal('minimum_grade', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_classes');
    }
};
