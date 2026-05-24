<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pastoral_support_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pastoral_counseling_case_id')->constrained()->cascadeOnDelete();
            $table->string('type')->index();
            $table->string('provider_name');
            $table->string('contact')->nullable();
            $table->string('status')->default('suggested')->index();
            $table->timestamp('referred_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_support_referrals');
    }
};
