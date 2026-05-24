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
        Schema::create('pastoral_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cell_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pastor_id')->nullable()->constrained('members')->nullOnDelete();
            $table->dateTime('scheduled_at')->nullable()->index();
            $table->dateTime('visited_at')->nullable();
            $table->string('visit_type')->default('pastoral')->index();
            $table->string('status')->default('scheduled')->index();
            $table->string('address')->nullable();
            $table->text('reason')->nullable();
            $table->text('summary')->nullable();
            $table->text('next_steps')->nullable();
            $table->boolean('requires_follow_up')->default(false);
            $table->date('follow_up_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastoral_visits');
    }
};
