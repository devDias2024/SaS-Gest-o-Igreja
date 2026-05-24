<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('preferred_name')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->string('whatsapp')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable()->index();
            $table->string('address_zip_code')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_complement')->nullable();
            $table->string('address_neighborhood')->nullable();
            $table->string('address_city')->nullable()->index();
            $table->string('address_state', 2)->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->date('conversion_date')->nullable();
            $table->date('baptism_date')->nullable();
            $table->string('ministry_role')->nullable()->index();
            $table->string('spiritual_status')->default('active')->index();
            $table->json('photos')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['full_name', 'birth_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
