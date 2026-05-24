<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('child_check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('child_age_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('checked_in_by_guardian_id')->nullable()->constrained('child_guardians')->nullOnDelete();
            $table->foreignId('checked_out_by_guardian_id')->nullable()->constrained('child_guardians')->nullOnDelete();
            $table->foreignId('pickup_authorization_id')->nullable()->constrained('child_pickup_authorizations')->nullOnDelete();
            $table->string('check_in_code')->unique();
            $table->string('pickup_code')->index();
            $table->timestamp('checked_in_at')->nullable()->index();
            $table->timestamp('checked_out_at')->nullable()->index();
            $table->timestamp('label_printed_at')->nullable();
            $table->string('status')->default('checked_in')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('child_check_ins');
    }
};
