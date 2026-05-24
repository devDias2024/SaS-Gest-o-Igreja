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
                    if (($block['type'] ?? null) !== 'home_hero') {
                        continue;
                    }

                    $data = array_replace([
                        'supporter_label' => 'Seja mantenedor',
                        'supporter_url' => '#doacoes',
                    ], $block['data'] ?? []);

                    $data['slides'] = collect($data['slides'] ?? [])
                        ->map(fn (array $slide): array => array_replace([
                            'supporter_label' => 'Seja mantenedor',
                            'supporter_url' => '#doacoes',
                        ], $slide))
                        ->all();

                    $blocks[$index]['data'] = $data;
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
