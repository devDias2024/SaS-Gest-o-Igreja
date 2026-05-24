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
        Schema::create('bank_statement_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->date('posted_at')->index();
            $table->string('bank_account')->nullable();
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('reference')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_statement_entries');
    }
};
