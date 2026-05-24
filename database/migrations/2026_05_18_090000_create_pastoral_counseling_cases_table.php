<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastoral_counseling_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('primary_pastor_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('status')->default('open')->index();
            $table->string('main_subject')->nullable()->index();
            $table->string('privacy_level')->default('confidential')->index();
            $table->timestamp('opened_at')->nullable()->index();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('lgpd_consented_at')->nullable();
            $table->text('lgpd_consent_text')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->text('risk_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('pastoral_counseling_case_user', function (Blueprint $table) {
            $table->unsignedBigInteger('pastoral_counseling_case_id');
            $table->unsignedBigInteger('user_id');
            $table->string('role')->default('authorized');
            $table->timestamps();

            $table->primary(['pastoral_counseling_case_id', 'user_id'], 'pastoral_case_user_primary');
            $table->foreign('pastoral_counseling_case_id', 'pastoral_case_user_case_fk')->references('id')->on('pastoral_counseling_cases')->cascadeOnDelete();
            $table->foreign('user_id', 'pastoral_case_user_user_fk')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_counseling_case_user');
        Schema::dropIfExists('pastoral_counseling_cases');
    }
};
