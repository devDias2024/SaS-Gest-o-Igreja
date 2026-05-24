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
        Schema::create('communication_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_campaign_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('communication_template_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('communication_provider_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('communication_inbox_thread_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('direction')->default('outbound');
            $table->string('channel');
            $table->string('recipient_name')->nullable();
            $table->string('recipient_contact')->nullable();
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('status')->default('queued');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->string('external_id')->nullable();
            $table->text('error_message')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communication_messages');
    }
};
