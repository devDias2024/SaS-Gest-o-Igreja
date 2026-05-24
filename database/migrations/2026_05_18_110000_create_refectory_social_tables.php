<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dining_menus', function (Blueprint $table) {
            $table->id();
            $table->date('menu_date')->index();
            $table->string('meal_type')->default('lunch')->index();
            $table->string('title');
            $table->text('items')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('meal_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_event_id')->nullable()->constrained()->nullOnDelete();
            $table->date('served_on')->index();
            $table->string('meal_type')->default('lunch')->index();
            $table->unsignedInteger('member_count')->default(0);
            $table->unsignedInteger('community_count')->default(0);
            $table->unsignedInteger('volunteer_count')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('dietary_restrictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->string('type')->index();
            $table->string('severity')->default('attention')->index();
            $table->string('description');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('food_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donor_member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('donor_name')->nullable();
            $table->string('donor_phone')->nullable();
            $table->date('donated_on')->index();
            $table->string('status')->default('received')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('food_donation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('food_donation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('unit')->default('un');
            $table->date('expires_on')->nullable()->index();
            $table->boolean('is_perishable')->default(false)->index();
            $table->timestamps();
        });

        Schema::create('social_pantry_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_phone')->nullable();
            $table->string('audience_type')->default('community')->index();
            $table->date('distributed_on')->index();
            $table->unsignedInteger('family_size')->nullable();
            $table->string('status')->default('delivered')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('social_pantry_distribution_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_pantry_distribution_id');
            $table->foreign('social_pantry_distribution_id', 'sp_distribution_item_distribution_fk')
                ->references('id')
                ->on('social_pantry_distributions')
                ->cascadeOnDelete();
            $table->foreignId('asset_id')->nullable()->constrained()->nullOnDelete();
            $table->string('item_type')->default('food')->index();
            $table->string('name');
            $table->decimal('quantity', 10, 2)->default(1);
            $table->string('unit')->default('un');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_pantry_distribution_items');
        Schema::dropIfExists('social_pantry_distributions');
        Schema::dropIfExists('food_donation_items');
        Schema::dropIfExists('food_donations');
        Schema::dropIfExists('dietary_restrictions');
        Schema::dropIfExists('meal_services');
        Schema::dropIfExists('dining_menus');
    }
};
