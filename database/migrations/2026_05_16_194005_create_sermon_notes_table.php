<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sermon_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sermon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name')->nullable()->index();
            $table->string('visibility')->default('private')->index();
            $table->text('body');
            $table->timestamps();

            $table->index(['sermon_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sermon_notes');
    }
};
