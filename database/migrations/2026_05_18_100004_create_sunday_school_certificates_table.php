<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_school_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sunday_school_enrollment_id')->constrained()->cascadeOnDelete();
            $table->string('certificate_number')->unique();
            $table->string('validation_token')->unique();
            $table->date('issued_on')->nullable();
            $table->string('status')->default('issued')->index();
            $table->string('signer_name')->nullable();
            $table->string('signer_title')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_school_certificates');
    }
};
