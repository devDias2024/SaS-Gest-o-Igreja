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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('financial_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cost_center_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('fund_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('financial_pledge_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->index();
            $table->date('transaction_date')->index();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->nullable()->index();
            $table->string('document_number')->nullable()->index();
            $table->string('source')->default('manual')->index();
            $table->boolean('is_anonymous')->default(false);
            $table->string('status')->default('confirmed')->index();
            $table->text('description')->nullable();
            $table->timestamp('receipt_sent_at')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->timestamps();

            $table->index(['type', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
