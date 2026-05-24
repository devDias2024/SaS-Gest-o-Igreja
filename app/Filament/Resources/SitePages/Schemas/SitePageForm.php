<?php

namespace App\Filament\Resources\SitePages\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SitePageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Pagina')->tabs([
                Tab::make('Dados')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('title')
                            ->label('Titulo')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state): void {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug((string) $state));
                                }
                            })
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')->label('Link amigavel')->required()->unique(ignoreRecord: true)->maxLength(255),
                        Select::make('type')->label('Tipo')->default('page')->required()->options([
                            'landing' => 'Landing page',
                            'page' => 'Pagina',
                            'ministry' => 'Ministerio',
                            'about' => 'Sobre a igreja',
                        ]),
                        Select::make('status')->label('Status')->default('draft')->required()->options([
                            'draft' => 'Rascunho',
                            'published' => 'Publicado',
                            'archived' => 'Arquivado',
                        ]),
                        DateTimePicker::make('published_at')->label('Publicado em')->native(false),
                    ]),
                ]),
                Tab::make('Editor visual')->schema(self::visualEditorSchema()),
                Tab::make('Menu e SEO')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        Toggle::make('show_in_menu')->label('Exibir no menu')->default(false),
                        TextInput::make('menu_order')->label('Ordem')->numeric()->default(0),
                        TextInput::make('menu_label')->label('Rotulo no menu')->maxLength(255),
                        TextInput::make('meta_title')->label('Titulo SEO')->maxLength(255),
                        Textarea::make('meta_description')->label('Descricao SEO')->rows(3)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }

    public static function visualEditorDefaults(): array
    {
        return [
            'home_theme' => [
                'brand_name' => 'Igreja Nacoes do Amor de Deus',
                'brand_short_name' => 'Nacoes do Amor',
                'brand_suffix' => 'de Deus',
                'logo_mark_text' => 'N',
                'logo_image' => null,
                'background_color' => '#0a0a12',
                'surface_color' => '#0c1445',
                'card_color' => '#111827',
                'gold_color' => '#d4af37',
                'gold_light_color' => '#f5d060',
                'text_color' => '#ffffff',
                'muted_color' => '#a8a8b3',
                'nav_font_size' => 14,
                'heading_font_size' => 56,
                'body_font_size' => 17,
                'button_font_size' => 14,
            ],
            'home_hero' => [
                'background_image' => null,
                'badge' => 'Bem-vindo a nossa familia',
                'title_prefix' => 'Igreja',
                'title_highlight' => 'Nacoes',
                'subtitle' => 'do Amor de Deus',
                'script_text' => 'Um lugar para recomecar',
                'description' => 'Familia, Fe e Esperanca',
                'primary_label' => 'Assistir Culto Ao Vivo',
                'primary_url' => '#aovivo',
                'secondary_label' => 'Seja um Mantenedor',
                'secondary_url' => '#mantenedores',
                'tertiary_label' => 'Como Chegar',
                'tertiary_url' => '#contato',
            ],
            'home_about' => [
                'eyebrow' => 'Quem Somos',
                'heading' => 'Uma casa de oracao para todas as nacoes',
                'body' => 'A Igreja Nacoes do Amor de Deus nasceu do chamado para ser um lugar de acolhimento, restauracao e amor. Acreditamos que cada pessoa e valiosa e tem um proposito divino.',
                'body_two' => 'Somos uma familia que ora juntos, cresce juntos e impacta nossa cidade com o amor de Cristo.',
                'image' => null,
                'history_years' => '15+',
                'history_label' => 'Anos de historia e amor',
                'stats' => [
                    ['value' => '500+', 'label' => 'Membros'],
                    ['value' => '12', 'label' => 'Ministerios'],
                    ['value' => '30+', 'label' => 'Celulas'],
                    ['value' => '5', 'label' => 'Missoes'],
                ],
            ],
            'home_live' => [
                'eyebrow' => 'Ao Vivo Agora',
                'heading' => 'Transmissao Ao Vivo',
                'description' => 'Assista nossos cultos e eventos em tempo real, de qualquer lugar.',
                'video_url' => null,
                'viewer_count' => '247',
                'schedules' => [
                    ['day' => 'Domingo', 'title' => 'Culto de Celebracao', 'time' => '09h e 18h'],
                    ['day' => 'Quarta', 'title' => 'Culto de Ensino', 'time' => '19h30'],
                    ['day' => 'Sexta', 'title' => 'Vigilia de Oracao', 'time' => '22h'],
                ],
            ],
            'home_radio' => [
                'eyebrow' => 'Radio Online',
                'heading' => 'Nacoes FM',
                'description' => 'Louvor e adoracao 24 horas por dia',
                'stream_url' => null,
                'current_song' => 'Eu Navegarei - Diante do Trono',
                'host' => 'Pr. Marcos Silva',
            ],
            'home_supporters' => [
                'eyebrow' => 'Seja um Mantenedor',
                'heading' => 'Faca parte dessa missao',
                'description' => 'Sua contribuicao transforma vidas, sustenta missoes e expande o Reino de Deus.',
                'pix_key' => 'nacoes@amordedeus.com.br',
                'plans' => [
                    ['name' => 'Bronze', 'amount' => '50', 'description' => 'Parceiro inicial', 'benefits' => 'Certificado digital; Nome no mural; Acesso a estudos exclusivos'],
                    ['name' => 'Prata', 'amount' => '100', 'description' => 'Parceiro especial', 'benefits' => 'Todos os beneficios Bronze; Carteirinha digital; Historico de contribuicoes; Eventos exclusivos'],
                    ['name' => 'Ouro', 'amount' => '250', 'description' => 'Parceiro premium', 'benefits' => 'Todos os beneficios Prata; Encontro com o pastor; Prioridade em eventos; Kit exclusivo'],
                ],
                'goals' => [
                    ['title' => 'Sede Nova', 'current' => 'R$ 134.000 arrecadados', 'percent' => '67'],
                    ['title' => 'Missoes Africa', 'current' => 'R$ 21.500 arrecadados', 'percent' => '43'],
                ],
            ],
            'home_prayer' => [
                'eyebrow' => 'Pedidos de Oracao',
                'heading' => 'Estamos orando por voce',
                'description' => 'Compartilhe seu pedido e nossa equipe de intercessao vai orar.',
            ],
            'home_events' => [
                'eyebrow' => 'Agenda',
                'heading' => 'Nossos Eventos',
                'description' => 'Fique por dentro de tudo que acontece na nossa igreja',
            ],
            'home_ministries' => [
                'eyebrow' => 'Ministerios',
                'heading' => 'Servindo juntos',
                'description' => 'Cada ministerio e uma expressao do amor de Deus. Encontre o seu lugar.',
                'items' => [
                    ['icon' => 'baby', 'title' => 'Infantil', 'subtitle' => '0 a 12 anos', 'description' => 'Ensinando as criancas no caminho do Senhor com amor e alegria.', 'leader' => 'Pra. Ana Costa', 'schedule' => 'Dom. 09h | Qua. 19h30'],
                    ['icon' => 'music', 'title' => 'Louvor', 'subtitle' => 'Adoracao & Musica', 'description' => 'Conduzindo o povo a presenca de Deus atraves da adoracao.', 'leader' => 'Pb. Lucas Melo', 'schedule' => 'Ensaios: Sab. 14h'],
                    ['icon' => 'flame', 'title' => 'Jovens', 'subtitle' => 'Geracao para Cristo', 'description' => 'Impactando a juventude com relevancia, verdade e paixao.', 'leader' => 'Ev. Rafael Santos', 'schedule' => 'Sab. 19h30'],
                    ['icon' => 'heart', 'title' => 'Mulheres', 'subtitle' => 'Virtude & Beleza', 'description' => 'Edificando mulheres virtuosas, fortes e cheias da graca.', 'leader' => 'Pra. Fernanda Lima', 'schedule' => 'Sab. 15h'],
                ],
            ],
            'home_gallery' => [
                'eyebrow' => 'Galeria',
                'heading' => 'Momentos de gloria',
                'description' => 'Recordacoes dos nossos encontros com Deus',
                'items' => [],
            ],
            'home_app' => [
                'eyebrow' => 'Aplicativo',
                'heading' => 'Leve a igreja no seu bolso',
                'description' => 'Acesse cultos ao vivo, estudos, radio, agenda e muito mais diretamente pelo celular.',
                'app_store_url' => '#',
                'google_play_url' => '#',
                'image' => null,
            ],
            'home_studies' => [
                'eyebrow' => 'Estudos & Devocionais',
                'heading' => 'Alimento para a alma',
                'description' => 'Aprofunde-se na Palavra de Deus todos os dias',
                'verse' => 'Porque eu bem sei os pensamentos que penso de vos, diz o Senhor; pensamentos de paz, e nao de mal, para vos dar o fim que esperais.',
                'verse_ref' => 'Jeremias 29:11',
            ],
            'home_contact' => [
                'eyebrow' => 'Contato',
                'heading' => 'Venha nos visitar',
                'description' => 'Estamos de bracos abertos esperando voce.',
                'address' => 'Rua da Esperanca, 1000 - Centro, Rio de Janeiro - RJ',
                'phone' => '(21) 99999-0000',
                'whatsapp' => '(21) 99999-0000',
                'email' => 'contato@nacoes.com.br',
                'office_hours' => 'Seg-Sex 9h-17h',
                'map_embed_url' => '',
                'instagram_url' => '#',
                'facebook_url' => '#',
                'youtube_url' => '#',
            ],
            'home_footer' => [
                'description' => 'Um lugar para recomecar. Familia, Fe e Esperanca. Todos sao bem-vindos na Casa do Pai.',
                'verse' => 'Porque Deus amou o mundo de tal maneira que deu o seu Filho unigenito',
                'verse_ref' => 'Joao 3:16',
            ],
        ];
    }

    public static function fillVisualEditorData(array $data): array
    {
        $blocks = collect($data['blocks'] ?? []);

        foreach (self::visualEditorDefaults() as $type => $defaults) {
            $blockData = array_replace_recursive($defaults, $blocks->firstWhere('type', $type)['data'] ?? []);

            foreach (array_keys($defaults) as $key) {
                $data["visual_{$type}_{$key}"] = $blockData[$key] ?? $defaults[$key];
            }
        }

        return $data;
    }

    public static function mergeVisualEditorData(array $data): array
    {
        $rawSlug = (string) ($data['slug'] ?? $data['title'] ?? '');
        $rawSlug = preg_replace('/https?:\/\/.*/', '', $rawSlug) ?: $rawSlug;
        $data['slug'] = Str::slug($rawSlug) ?: Str::slug((string) ($data['title'] ?? 'pagina'));

        $blocks = $data['blocks'] ?? [];

        foreach (self::visualEditorDefaults() as $type => $defaults) {
            $blockData = [];

            foreach ($defaults as $key => $default) {
                $field = "visual_{$type}_{$key}";
                $blockData[$key] = $data[$field] ?? $default;
                unset($data[$field]);
            }

            $blocks = self::upsertBlock($blocks, $type, $blockData);
        }

        $data['blocks'] = $blocks;

        return $data;
    }

    private static function upsertBlock(array $blocks, string $type, array $blockData): array
    {
        foreach ($blocks as $index => $block) {
            if (($block['type'] ?? null) === $type) {
                $blocks[$index]['data'] = $blockData;

                return $blocks;
            }
        }

        $blocks[] = ['type' => $type, 'data' => $blockData];

        return $blocks;
    }

    private static function visualEditorSchema(): array
    {
        return [
            Tabs::make('Editor do site')->tabs([
                Tab::make('Marca')->schema([
                    Section::make('Identidade visual')->schema([
                        Grid::make(['default' => 1, 'md' => 3])->schema([
                            TextInput::make('visual_home_theme_brand_name')->label('Nome completo')->columnSpanFull(),
                            TextInput::make('visual_home_theme_brand_short_name')->label('Nome curto'),
                            TextInput::make('visual_home_theme_brand_suffix')->label('Complemento'),
                            TextInput::make('visual_home_theme_logo_mark_text')->label('Letra sem logo')->maxLength(8),
                            FileUpload::make('visual_home_theme_logo_image')->label('Logo')->image()->disk('public')->directory('site/logos')->columnSpanFull(),
                        ]),
                    ]),
                    Section::make('Cores e fontes')->schema([
                        Grid::make(['default' => 1, 'md' => 4])->schema([
                            ColorPicker::make('visual_home_theme_background_color')->label('Fundo'),
                            ColorPicker::make('visual_home_theme_surface_color')->label('Topo/areas'),
                            ColorPicker::make('visual_home_theme_card_color')->label('Cards'),
                            ColorPicker::make('visual_home_theme_gold_color')->label('Dourado'),
                            ColorPicker::make('visual_home_theme_gold_light_color')->label('Dourado claro'),
                            ColorPicker::make('visual_home_theme_text_color')->label('Texto'),
                            ColorPicker::make('visual_home_theme_muted_color')->label('Texto secundario'),
                            TextInput::make('visual_home_theme_nav_font_size')->label('Menu')->numeric()->suffix('px'),
                            TextInput::make('visual_home_theme_heading_font_size')->label('Titulos')->numeric()->suffix('px'),
                            TextInput::make('visual_home_theme_body_font_size')->label('Textos')->numeric()->suffix('px'),
                            TextInput::make('visual_home_theme_button_font_size')->label('Botoes')->numeric()->suffix('px'),
                        ]),
                    ]),
                ]),
                Tab::make('Hero')->schema([
                    Section::make('Primeira dobra')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            FileUpload::make('visual_home_hero_background_image')->label('Imagem de fundo')->image()->disk('public')->directory('site/hero')->columnSpanFull(),
                            TextInput::make('visual_home_hero_badge')->label('Etiqueta')->columnSpanFull(),
                            TextInput::make('visual_home_hero_title_prefix')->label('Titulo antes do destaque'),
                            TextInput::make('visual_home_hero_title_highlight')->label('Destaque dourado'),
                            TextInput::make('visual_home_hero_subtitle')->label('Subtitulo')->columnSpanFull(),
                            TextInput::make('visual_home_hero_script_text')->label('Frase manuscrita')->columnSpanFull(),
                            TextInput::make('visual_home_hero_description')->label('Descricao')->columnSpanFull(),
                            TextInput::make('visual_home_hero_primary_label')->label('Botao principal'),
                            TextInput::make('visual_home_hero_primary_url')->label('Link principal'),
                            TextInput::make('visual_home_hero_secondary_label')->label('Botao mantenedor'),
                            TextInput::make('visual_home_hero_secondary_url')->label('Link mantenedor'),
                            TextInput::make('visual_home_hero_tertiary_label')->label('Botao localizacao'),
                            TextInput::make('visual_home_hero_tertiary_url')->label('Link localizacao'),
                        ]),
                    ]),
                ]),
                Tab::make('Sobre e midia')->schema([
                    Section::make('Sobre')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('visual_home_about_eyebrow')->label('Texto pequeno'),
                            TextInput::make('visual_home_about_heading')->label('Titulo')->columnSpanFull(),
                            Textarea::make('visual_home_about_body')->label('Texto 1')->rows(3)->columnSpanFull(),
                            Textarea::make('visual_home_about_body_two')->label('Texto 2')->rows(3)->columnSpanFull(),
                            FileUpload::make('visual_home_about_image')->label('Imagem')->image()->disk('public')->directory('site/about')->columnSpanFull(),
                            TextInput::make('visual_home_about_history_years')->label('Numero destaque'),
                            TextInput::make('visual_home_about_history_label')->label('Legenda destaque'),
                        ]),
                        Repeater::make('visual_home_about_stats')->label('Numeros')->schema([
                            TextInput::make('value')->label('Valor')->required(),
                            TextInput::make('label')->label('Legenda')->required(),
                        ])->columns(2)->columnSpanFull(),
                    ]),
                    Section::make('Ao vivo')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('visual_home_live_eyebrow')->label('Status'),
                            TextInput::make('visual_home_live_heading')->label('Titulo'),
                            Textarea::make('visual_home_live_description')->label('Descricao')->rows(2)->columnSpanFull(),
                            TextInput::make('visual_home_live_video_url')->label('URL do video/live'),
                            TextInput::make('visual_home_live_viewer_count')->label('Pessoas assistindo'),
                        ]),
                        Repeater::make('visual_home_live_schedules')->label('Horarios')->schema([
                            TextInput::make('day')->label('Dia')->required(),
                            TextInput::make('title')->label('Culto')->required(),
                            TextInput::make('time')->label('Horario')->required(),
                        ])->columns(3)->columnSpanFull(),
                    ]),
                    Section::make('Radio')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('visual_home_radio_eyebrow')->label('Texto pequeno'),
                            TextInput::make('visual_home_radio_heading')->label('Titulo'),
                            Textarea::make('visual_home_radio_description')->label('Descricao')->rows(2)->columnSpanFull(),
                            TextInput::make('visual_home_radio_stream_url')->label('URL do streaming'),
                            TextInput::make('visual_home_radio_current_song')->label('Musica atual'),
                            TextInput::make('visual_home_radio_host')->label('Locutor'),
                        ]),
                    ]),
                ]),
                Tab::make('Mantenedores')->schema([
                    Section::make('Chamada')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('visual_home_supporters_eyebrow')->label('Texto pequeno'),
                            TextInput::make('visual_home_supporters_heading')->label('Titulo'),
                            Textarea::make('visual_home_supporters_description')->label('Descricao')->rows(2)->columnSpanFull(),
                            TextInput::make('visual_home_supporters_pix_key')->label('Chave PIX')->columnSpanFull(),
                        ]),
                    ]),
                    Section::make('Planos')->schema([
                        Repeater::make('visual_home_supporters_plans')->label('Planos')->schema([
                            TextInput::make('name')->label('Nome')->required(),
                            TextInput::make('amount')->label('Valor mensal')->numeric()->required(),
                            TextInput::make('description')->label('Descricao'),
                            Textarea::make('benefits')->label('Beneficios separados por ponto e virgula')->rows(3)->columnSpanFull(),
                        ])->columns(3)->columnSpanFull(),
                    ]),
                    Section::make('Metas')->schema([
                        Repeater::make('visual_home_supporters_goals')->label('Metas')->schema([
                            TextInput::make('title')->label('Titulo')->required(),
                            TextInput::make('current')->label('Valor atual')->required(),
                            TextInput::make('percent')->label('Percentual')->numeric()->suffix('%')->required(),
                        ])->columns(3)->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Conteudo')->schema([
                    Section::make('Oracao')->schema([
                        TextInput::make('visual_home_prayer_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_prayer_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_prayer_description')->label('Descricao')->rows(2)->columnSpanFull(),
                    ]),
                    Section::make('Agenda')->schema([
                        TextInput::make('visual_home_events_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_events_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_events_description')->label('Descricao')->rows(2)->columnSpanFull(),
                    ]),
                    Section::make('Ministerios')->schema([
                        TextInput::make('visual_home_ministries_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_ministries_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_ministries_description')->label('Descricao')->rows(2)->columnSpanFull(),
                        Repeater::make('visual_home_ministries_items')->label('Cards')->schema([
                            TextInput::make('icon')->label('Icone lucide')->helperText('Ex: baby, music, flame, heart'),
                            TextInput::make('title')->label('Titulo')->required(),
                            TextInput::make('subtitle')->label('Subtitulo'),
                            Textarea::make('description')->label('Descricao')->rows(2)->columnSpanFull(),
                            TextInput::make('leader')->label('Lider'),
                            TextInput::make('schedule')->label('Horario'),
                        ])->columns(2)->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Galeria, app e estudos')->schema([
                    Section::make('Galeria')->schema([
                        TextInput::make('visual_home_gallery_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_gallery_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_gallery_description')->label('Descricao')->rows(2)->columnSpanFull(),
                        Repeater::make('visual_home_gallery_items')->label('Imagens')->schema([
                            FileUpload::make('image')->label('Imagem')->image()->disk('public')->directory('site/gallery')->columnSpanFull(),
                            TextInput::make('title')->label('Titulo'),
                            Select::make('category')->label('Categoria')->options([
                                'congresso' => 'Congresso',
                                'batismo' => 'Batismo',
                                'ceia' => 'Santa Ceia',
                                'eventos' => 'Eventos',
                            ]),
                        ])->columns(2)->columnSpanFull(),
                    ]),
                    Section::make('Aplicativo')->schema([
                        TextInput::make('visual_home_app_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_app_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_app_description')->label('Descricao')->rows(2)->columnSpanFull(),
                        TextInput::make('visual_home_app_app_store_url')->label('App Store'),
                        TextInput::make('visual_home_app_google_play_url')->label('Google Play'),
                        FileUpload::make('visual_home_app_image')->label('Imagem do app')->image()->disk('public')->directory('site/app')->columnSpanFull(),
                    ]),
                    Section::make('Estudos')->schema([
                        TextInput::make('visual_home_studies_eyebrow')->label('Texto pequeno'),
                        TextInput::make('visual_home_studies_heading')->label('Titulo')->columnSpanFull(),
                        Textarea::make('visual_home_studies_description')->label('Descricao')->rows(2)->columnSpanFull(),
                        Textarea::make('visual_home_studies_verse')->label('Versiculo')->rows(3)->columnSpanFull(),
                        TextInput::make('visual_home_studies_verse_ref')->label('Referencia'),
                    ]),
                ]),
                Tab::make('Contato e rodape')->schema([
                    Section::make('Contato')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('visual_home_contact_eyebrow')->label('Texto pequeno'),
                            TextInput::make('visual_home_contact_heading')->label('Titulo'),
                            Textarea::make('visual_home_contact_description')->label('Descricao')->rows(2)->columnSpanFull(),
                            TextInput::make('visual_home_contact_address')->label('Endereco')->columnSpanFull(),
                            TextInput::make('visual_home_contact_phone')->label('Telefone'),
                            TextInput::make('visual_home_contact_whatsapp')->label('WhatsApp'),
                            TextInput::make('visual_home_contact_email')->label('E-mail')->email(),
                            TextInput::make('visual_home_contact_office_hours')->label('Secretaria'),
                            TextInput::make('visual_home_contact_map_embed_url')->label('URL embed do mapa')->columnSpanFull(),
                            TextInput::make('visual_home_contact_instagram_url')->label('Instagram'),
                            TextInput::make('visual_home_contact_facebook_url')->label('Facebook'),
                            TextInput::make('visual_home_contact_youtube_url')->label('YouTube'),
                        ]),
                    ]),
                    Section::make('Rodape')->schema([
                        Textarea::make('visual_home_footer_description')->label('Descricao')->rows(3)->columnSpanFull(),
                        Textarea::make('visual_home_footer_verse')->label('Versiculo')->rows(2)->columnSpanFull(),
                        TextInput::make('visual_home_footer_verse_ref')->label('Referencia'),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ];
    }
}
