<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sunday_school_enrollment_id')->constrained()->cascadeOnDelete();
            $table->date('lesson_date')->index();
            $table->string('lesson_title')->nullable();
            $table->string('status')->default('present')->index();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['sunday_school_enrollment_id', 'lesson_date'], 'ss_attendance_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_attendances');
    }
};
