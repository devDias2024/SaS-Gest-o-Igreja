<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_form_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_form_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('visitor_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->string('submitter_name')->nullable();
            $table->string('submitter_email')->nullable();
            $table->string('submitter_phone')->nullable();
            $table->string('status')->default('pending')->index();
            $table->json('answers')->nullable();
            $table->json('files')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamp('submitted_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_form_submissions');
    }
};
