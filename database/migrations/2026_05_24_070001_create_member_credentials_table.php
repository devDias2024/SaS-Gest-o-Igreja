<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_credential_template_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('validation_token')->unique();
            $table->string('title')->default('Membro');
            $table->string('blood_type')->nullable();
            $table->date('issued_on')->index();
            $table->date('expires_on')->nullable()->index();
            $table->string('status')->default('active')->index();
            $table->boolean('issuance_registered')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['member_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_credentials');
    }
};
