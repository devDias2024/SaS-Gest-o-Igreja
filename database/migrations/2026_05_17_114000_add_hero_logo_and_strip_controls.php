<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_pages')
            ->where('slug', 'home')
            ->get()
            ->each(function ($page): void {
                $blocks = json_decode($page->blocks ?: '[]', true) ?: [];

                foreach ($blocks as $index => $block) {
                    if (($block['type'] ?? null) === 'home_theme') {
                        $blocks[$index]['data'] = array_replace([
                            'show_color_strip' => false,
                        ], $block['data'] ?? []);
                    }

                    if (($block['type'] ?? null) === 'home_hero') {
                        $blocks[$index]['data'] = array_replace([
                            'logo_image' => null,
                            'logo_mark_text' => 'AD',
                        ], $block['data'] ?? []);
                    }
                }

                DB::table('site_pages')
                    ->where('id', $page->id)
                    ->update([
                        'blocks' => json_encode($blocks),
                        'updated_at' => $page->updated_at,
                    ]);
            });
    }

    public function down(): void
    {
        //
    }
};
