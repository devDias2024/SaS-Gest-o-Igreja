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
                $found = false;

                foreach ($blocks as $index => $block) {
                    if (($block['type'] ?? null) !== 'home_theme') {
                        continue;
                    }

                    $blocks[$index]['data'] = array_replace([
                        'brand_name' => config('app.name', 'Igreja'),
                        'logo_mark_text' => 'AD',
                        'logo_image' => null,
                    ], $block['data'] ?? []);

                    $found = true;
                    break;
                }

                if (! $found) {
                    $blocks[] = [
                        'type' => 'home_theme',
                        'data' => [
                            'brand_name' => config('app.name', 'Igreja'),
                            'logo_mark_text' => 'AD',
                            'logo_image' => null,
                            'primary_color' => '#005f51',
                            'primary_dark_color' => '#003c33',
                            'primary_soft_color' => '#087264',
                            'accent_color' => '#ff941f',
                            'cream_color' => '#fff2bc',
                            'text_color' => '#392f31',
                            'muted_color' => '#756b68',
                            'background_color' => '#f7f7f5',
                        ],
                    ];
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
