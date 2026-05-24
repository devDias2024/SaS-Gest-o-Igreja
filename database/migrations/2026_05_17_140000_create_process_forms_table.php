<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('process_forms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('template_key')->nullable();
            $table->string('status')->default('draft')->index();
            $table->string('access_mode')->default('public')->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->unsignedInteger('response_limit')->nullable();
            $table->boolean('captcha_enabled')->default(true);
            $table->boolean('allow_drafts')->default(false);
            $table->string('redirect_url')->nullable();
            $table->text('confirmation_message')->nullable();
            $table->json('fields')->nullable();
            $table->json('mappings')->nullable();
            $table->json('automations')->nullable();
            $table->json('webhooks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('process_forms');
    }
};
