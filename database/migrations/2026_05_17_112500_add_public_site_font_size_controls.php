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
                            'nav_font_size' => 11,
                            'brand_font_size' => 13,
                            'heading_font_size' => 47,
                            'body_font_size' => 16,
                            'button_font_size' => 11,
                        ], $block['data'] ?? []);
                    }

                    if (($block['type'] ?? null) === 'home_hero') {
                        $data = array_replace([
                            'main_font_size' => 168,
                            'side_font_size' => 134,
                            'tagline_font_size' => 15,
                            'caption_font_size' => 13,
                        ], $block['data'] ?? []);

                        $data['slides'] = collect($data['slides'] ?? [])
                            ->map(fn (array $slide): array => array_replace([
                                'main_font_size' => 168,
                                'side_font_size' => 134,
                                'tagline_font_size' => 15,
                                'caption_font_size' => 13,
                            ], $slide))
                            ->all();

                        $blocks[$index]['data'] = $data;
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
