<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('site_pages')->where('slug', 'home')->first();

        if (! $page) {
            DB::table('site_pages')->insert([
                'title' => 'Landing page para visitantes',
                'slug' => 'home',
                'type' => 'landing',
                'status' => 'published',
                'show_in_menu' => false,
                'published_at' => now(),
                'blocks' => json_encode($this->defaultBlocks()),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        $blocks = json_decode($page->blocks ?: '[]', true) ?: [];
        $legacyHero = collect($blocks)->firstWhere('type', 'hero')['data'] ?? [];
        $defaults = $this->defaultBlocks($legacyHero);

        foreach ($defaults as $defaultBlock) {
            $index = collect($blocks)->search(fn (array $block): bool => ($block['type'] ?? null) === $defaultBlock['type']);

            if ($index === false) {
                $blocks[] = $defaultBlock;

                continue;
            }

            $blocks[$index]['data'] = array_replace_recursive(
                $defaultBlock['data'],
                $blocks[$index]['data'] ?? [],
            );
        }

        DB::table('site_pages')
            ->where('id', $page->id)
            ->update([
                'blocks' => json_encode($blocks),
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        //
    }

    private function defaultBlocks(array $legacyHero = []): array
    {
        return [
            [
                'type' => 'home_hero',
                'data' => [
                    'logo_text' => 'Assembleia de Deus',
                    'years' => '114',
                    'years_label' => 'anos',
                    'tagline' => 'Abencoando as pessoas e cuidando do meio ambiente',
                    'caption' => 'Sal da terra e luz do mundo',
                ],
            ],
            [
                'type' => 'home_intro',
                'data' => [
                    'heading' => $legacyHero['heading'] ?? 'Assembleia de Deus em Belem',
                    'body' => $legacyHero['subheading'] ?? 'Bem-vindo a Assembleia de Deus em Belem, uma igreja dedicada a servir e compartilhar o amor de Cristo. Nosso compromisso e acolher, discipular e impactar positivamente vidas pela Palavra de Deus.',
                    'primary_label' => 'Nossa historia',
                    'primary_url' => '/paginas/sobre',
                    'video_label' => 'Video institucional',
                    'video_url' => '/pregacoes',
                    'stats' => [
                        ['value' => '114', 'label' => 'Anos de existencia'],
                        ['value' => '550', 'label' => 'Templos'],
                        ['value' => '166,122', 'label' => 'Membros'],
                        ['value' => '34', 'label' => 'Missoes'],
                    ],
                ],
            ],
            [
                'type' => 'home_news',
                'data' => [
                    'eyebrow' => 'Nossas',
                    'heading' => 'Noticias & Conteudos',
                    'profile_name' => 'igrejaoficial',
                    'profile_followers' => '24.699 seguidores',
                    'primary_label' => 'Ver mais',
                    'secondary_label' => 'Siga e fale conosco',
                ],
            ],
            [
                'type' => 'home_missions',
                'data' => [
                    'eyebrow' => 'Nossas missoes',
                    'heading' => 'Nossa geracao, nosso proposito',
                    'items' => [
                        ['title' => 'Missao com a Primeirissima Infancia', 'button_label' => 'Saber mais', 'button_url' => '#visitante'],
                        ['title' => 'Missao com Criancas', 'button_label' => 'Saber mais', 'button_url' => '#visitante'],
                        ['title' => 'Missao com Familias', 'button_label' => 'Saber mais', 'button_url' => '#visitante'],
                    ],
                ],
            ],
            [
                'type' => 'home_events',
                'data' => [
                    'eyebrow' => 'Assembleia de Deus - Belem (PA)',
                    'heading' => 'Nossos Eventos',
                    'button_label' => 'Ver todos',
                ],
            ],
            [
                'type' => 'home_donation',
                'data' => [
                    'eyebrow' => 'Faca sua doacao',
                    'heading' => 'Contribua para o crescimento da obra de Deus.',
                    'button_label' => 'Faca sua doacao',
                ],
            ],
            [
                'type' => 'home_forms',
                'data' => [
                    'visitor_eyebrow' => 'Visitantes',
                    'visitor_heading' => 'Seja um visitante',
                    'visitor_button_label' => 'Enviar cadastro',
                    'contact_eyebrow' => 'Contato',
                    'contact_heading' => 'Fale conosco',
                    'contact_button_label' => 'Enviar mensagem',
                    'sermons_eyebrow' => 'Pregacoes',
                    'sermons_heading' => 'Arquivo recente',
                ],
            ],
        ];
    }
};
