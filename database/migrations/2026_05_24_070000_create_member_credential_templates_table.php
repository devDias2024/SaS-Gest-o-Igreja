<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_credential_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('church_name')->nullable();
            $table->string('authority_name')->nullable();
            $table->string('authority_title')->nullable();
            $table->string('front_background')->nullable();
            $table->string('back_background')->nullable();
            $table->string('background_color', 20)->default('#d97706');
            $table->string('text_color', 20)->default('#ffffff');
            $table->string('photo_shape')->default('round');
            $table->string('border_shape')->default('rounded');
            $table->string('document_type')->default('member');
            $table->text('back_description')->nullable();
            $table->boolean('show_holder_signature')->default(true);
            $table->boolean('show_authority_signature')->default(true);
            $table->unsignedInteger('default_validity_months')->default(12);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        DB::table('member_credential_templates')->insert([
            'name' => 'Credencial padrao',
            'church_name' => config('app.name', 'SaaS Igreja'),
            'background_color' => '#d97706',
            'text_color' => '#ffffff',
            'photo_shape' => 'round',
            'border_shape' => 'rounded',
            'document_type' => 'member',
            'back_description' => 'Esta credencial identifica seu portador como membro da comunidade local.',
            'show_holder_signature' => true,
            'show_authority_signature' => true,
            'default_validity_months' => 12,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('member_credential_templates');
    }
};
