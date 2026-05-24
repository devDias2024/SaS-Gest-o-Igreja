<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermon_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sermon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('viewer_name')->nullable();
            $table->string('source')->default('admin')->index();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->unsignedInteger('watched_seconds')->default(0);
            $table->timestamp('viewed_at')->index();
            $table->timestamps();

            $table->index(['sermon_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermon_views');
    }
};
