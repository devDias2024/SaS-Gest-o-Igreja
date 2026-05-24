<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sermon_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sermon_series_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('preacher_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->dateTime('preached_at')->nullable()->index();
            $table->string('status')->default('draft')->index();
            $table->string('visibility')->default('public')->index();
            $table->string('scripture_reference')->nullable();
            $table->text('summary')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('allow_download')->default(false)->index();
            $table->boolean('allow_sharing')->default(true)->index();
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'visibility']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermons');
    }
};
