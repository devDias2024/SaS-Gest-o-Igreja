<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('asset_location_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique();
            $table->string('barcode')->nullable()->index();
            $table->text('qr_code_payload')->nullable();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('asset_type')->default('asset')->index();
            $table->string('status')->default('available')->index();
            $table->string('condition')->default('good')->index();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->index();
            $table->date('acquisition_date')->nullable();
            $table->decimal('purchase_value', 12, 2)->default(0);
            $table->decimal('residual_value', 12, 2)->default(0);
            $table->unsignedInteger('useful_life_months')->nullable();
            $table->date('warranty_expires_at')->nullable()->index();
            $table->date('next_maintenance_at')->nullable()->index();
            $table->decimal('quantity_on_hand', 12, 2)->default(1);
            $table->decimal('minimum_quantity', 12, 2)->default(0);
            $table->string('unit')->default('un');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['asset_type', 'status']);
            $table->index(['asset_location_id', 'asset_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
