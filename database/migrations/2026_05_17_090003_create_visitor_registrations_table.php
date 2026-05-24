<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('communication_inbox_thread_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable()->index();
            $table->date('planned_visit_on')->nullable()->index();
            $table->string('preferred_service')->nullable();
            $table->unsignedSmallInteger('party_size')->default(1);
            $table->text('notes')->nullable();
            $table->string('status')->default('new')->index();
            $table->timestamp('contacted_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_registrations');
    }
};
