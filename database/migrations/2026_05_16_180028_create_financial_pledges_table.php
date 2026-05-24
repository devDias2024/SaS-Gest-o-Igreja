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
        Schema::create('financial_pledges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fund_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('tithe')->index();
            $table->decimal('monthly_amount', 12, 2);
            $table->unsignedTinyInteger('due_day')->default(10);
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->string('status')->default('active')->index();
            $table->date('last_reminder_sent_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_pledges');
    }
};
