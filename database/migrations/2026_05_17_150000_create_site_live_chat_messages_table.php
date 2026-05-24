<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_live_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Visitante');
            $table->string('message', 600);
            $table->boolean('is_approved')->default(true);
            $table->string('ip_address', 64)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_live_chat_messages');
    }
};
