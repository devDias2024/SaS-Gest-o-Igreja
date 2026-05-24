<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermon_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sermon_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('media_type')->index();
            $table->string('source')->default('upload')->index();
            $table->string('disk')->default('public');
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('embed_url')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->boolean('is_primary')->default(false)->index();
            $table->boolean('allow_download')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermon_media');
    }
};
