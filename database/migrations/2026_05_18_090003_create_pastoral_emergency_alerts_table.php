<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastoral_emergency_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pastoral_counseling_case_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('triggered_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('open')->index();
            $table->string('contact_phone')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('triggered_at')->nullable()->index();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_emergency_alerts');
    }
};
