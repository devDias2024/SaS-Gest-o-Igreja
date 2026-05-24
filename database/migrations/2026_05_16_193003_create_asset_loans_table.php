<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('borrower_name')->nullable()->index();
            $table->string('borrower_contact')->nullable();
            $table->date('loaned_at')->index();
            $table->date('due_at')->nullable()->index();
            $table->date('returned_at')->nullable()->index();
            $table->string('status')->default('open')->index();
            $table->string('condition_out')->nullable();
            $table->string('condition_in')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_loans');
    }
};
