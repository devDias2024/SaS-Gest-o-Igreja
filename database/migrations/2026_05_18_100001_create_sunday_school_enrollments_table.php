<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sunday_school_class_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->date('enrolled_on')->nullable();
            $table->date('completed_on')->nullable();
            $table->string('status')->default('active')->index();
            $table->decimal('final_grade', 5, 2)->nullable();
            $table->unsignedTinyInteger('attendance_percent')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['sunday_school_class_id', 'member_id'], 'ss_enrollment_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_enrollments');
    }
};
