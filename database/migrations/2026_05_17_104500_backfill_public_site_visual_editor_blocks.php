<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_pages')
            ->where('type', 'landing')
            ->orderBy('id')
            ->get()
            ->each(function ($page): void {
                $blocks = json_decode($page->blocks ?: '[]', true) ?: [];

                $blocks = $this->upsertBlock($blocks, 'home_theme', [
                    'primary_color' => '#005f51',
                    'primary_dark_color' => '#003c33',
                    'primary_soft_color' => '#087264',
                    'accent_color' => '#ff941f',
                    'cream_color' => '#fff2bc',
                    'text_color' => '#392f31',
                    'muted_color' => '#756b68',
                    'background_color' => '#f7f7f5',
                ]);

                $blocks = $this->upsertBlock($blocks, 'home_hero', [
                    'logo_text' => 'Assembleia de Deus',
                    'years' => '114',
                    'years_label' => 'anos',
                    'tagline' => 'Abencoando as pessoas e cuidando do meio ambiente',
                    'caption' => 'Sal da terra e luz do mundo',
                    'background_color' => '#005f51',
                    'text_color' => '#f7e7a7',
                    'accent_color' => '#f4d77a',
                    'slides' => [],
                ]);

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

    private function upsertBlock(array $blocks, string $type, array $defaults): array
    {
        foreach ($blocks as $index => $block) {
            if (($block['type'] ?? null) !== $type) {
                continue;
            }

            $blocks[$index]['data'] = array_replace_recursive($defaults, $block['data'] ?? []);

            return $blocks;
        }

        $blocks[] = [
            'type' => $type,
            'data' => $defaults,
        ];

        return $blocks;
    }
};
