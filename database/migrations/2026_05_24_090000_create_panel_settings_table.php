<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panel_settings', function (Blueprint $table) {
            $table->id();
            $table->string('panel_name')->default('SaaS Igreja');
            $table->string('panel_logo')->nullable();
            $table->string('panel_logo_dark')->nullable();
            $table->string('favicon')->nullable();
            $table->string('primary_color', 20)->default('#f59e0b');
            $table->string('font_family')->default('Instrument Sans');
            $table->string('theme_mode')->default('dark');
            $table->string('visual_style')->default('awin');
            $table->string('sidebar_width', 20)->default('20rem');
            $table->boolean('allow_dark_mode')->default(true);
            $table->boolean('collapsible_groups')->default(true);
            $table->boolean('collapsible_sidebar')->default(false);
            $table->boolean('top_navigation')->default(false);
            $table->timestamps();
        });

        DB::table('panel_settings')->insert([
            'panel_name' => config('app.name', 'SaaS Igreja'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('panel_settings');
    }
};
