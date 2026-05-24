<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sunday_school_enrollment_id')->constrained()->cascadeOnDelete();
            $table->string('lesson_title');
            $table->date('graded_on')->nullable();
            $table->string('grade_type')->default('numeric')->index();
            $table->decimal('numeric_grade', 5, 2)->nullable();
            $table->string('concept_grade')->nullable();
            $table->decimal('weight', 5, 2)->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_grades');
    }
};
