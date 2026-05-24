<?php

namespace Database\Seeders;

use App\Models\CostCenter;
use App\Models\ChildAgeGroup;
use App\Models\EventLocation;
use App\Models\CommunicationProvider;
use App\Models\CommunicationTemplate;
use App\Models\FinancialCategory;
use App\Models\Fund;
use App\Models\Ministry;
use App\Models\BlogPost;
use App\Models\ProcessForm;
use App\Models\SitePage;
use App\Models\User;
use App\Models\VolunteerRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
        ]);

        foreach (['Dizimos', 'Ofertas', 'Receitas gerais'] as $name) {
            FinancialCategory::query()->firstOrCreate(
                ['name' => $name],
                ['type' => 'income', 'color' => 'success', 'is_active' => true],
            );
        }

        foreach (['Administrativo', 'Ministerios', 'Manutencao', 'Eventos'] as $name) {
            CostCenter::query()->firstOrCreate(
                ['name' => $name],
                ['code' => Str::slug($name), 'is_active' => true],
            );
        }

        foreach (['Missoes', 'Construcao', 'Acao Social', 'Geral'] as $name) {
            Fund::query()->firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'opening_balance' => 0, 'is_restricted' => $name !== 'Geral'],
            );
        }

        EventLocation::query()->firstOrCreate(
            ['name' => 'Templo principal'],
            [
                'capacity' => 300,
                'geofence_radius_meters' => 120,
                'is_active' => true,
            ],
        );

        foreach (['Louvor', 'Recepcao', 'Midia', 'Infantil', 'Intercessao'] as $name) {
            VolunteerRole::query()->firstOrCreate(
                ['name' => $name],
                ['default_slots' => 1, 'rotates_automatically' => true, 'is_active' => true],
            );
        }

        foreach (['Celulas', 'Discipulado', 'Jovens', 'Mulheres', 'Homens'] as $name) {
            Ministry::query()->firstOrCreate(
                ['name' => $name],
                ['type' => $name === 'Celulas' ? 'cell_network' : 'ministry', 'status' => 'active'],
            );
        }

        foreach ([
            ['name' => 'Bercario', 'min_age_months' => 0, 'max_age_months' => 24],
            ['name' => 'Maternal', 'min_age_months' => 25, 'max_age_months' => 48],
            ['name' => 'Primarios', 'min_age_months' => 49, 'max_age_months' => 96],
            ['name' => 'Juniores', 'min_age_months' => 97, 'max_age_months' => 144],
        ] as $group) {
            ChildAgeGroup::query()->firstOrCreate(
                ['name' => $group['name']],
                $group + ['is_active' => true],
            );
        }

        $providers = [
            ['name' => 'E-mail padrao', 'channel' => 'email', 'driver' => 'smtp', 'sender_name' => 'Igreja', 'sender_address' => 'contato@igreja.local'],
            ['name' => 'WhatsApp Evolution', 'channel' => 'whatsapp', 'driver' => 'evolution_api'],
            ['name' => 'SMS padrao', 'channel' => 'sms', 'driver' => 'manual'],
        ];

        foreach ($providers as $provider) {
            CommunicationProvider::query()->firstOrCreate(
                ['name' => $provider['name']],
                $provider + ['is_active' => true],
            );
        }

        foreach ([
            ['name' => 'Boas-vindas', 'slug' => 'boas-vindas', 'channel' => 'whatsapp', 'category' => 'welcome', 'body' => 'Ola {{nome}}, seja bem-vindo(a)! Estamos felizes por caminhar com voce.'],
            ['name' => 'Aniversario', 'slug' => 'aniversario', 'channel' => 'whatsapp', 'category' => 'birthday', 'body' => 'Parabens, {{nome}}! Que Deus abencoe sua vida hoje e sempre.'],
            ['name' => 'Ausencia 3 semanas', 'slug' => 'ausencia-3-semanas', 'channel' => 'whatsapp', 'category' => 'absence', 'body' => 'Ola {{nome}}, sentimos sua falta. Podemos orar por voce?'],
            ['name' => 'Novo evento', 'slug' => 'novo-evento', 'channel' => 'email', 'category' => 'event', 'subject' => 'Temos um novo evento para voce', 'body' => 'Ola {{nome}}, confira os detalhes do evento {{evento}}.'],
        ] as $template) {
            CommunicationTemplate::query()->firstOrCreate(
                ['slug' => $template['slug']],
                $template + ['is_active' => true],
            );
        }

        SitePage::query()->firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Landing page para visitantes',
                'type' => 'landing',
                'status' => 'published',
                'show_in_menu' => false,
                'published_at' => now(),
                'blocks' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'heading' => 'Uma igreja para visitar, pertencer e servir',
                            'subheading' => 'Encontre a agenda publica, pregacoes, doacoes e um cadastro rapido para nossa equipe preparar sua primeira visita.',
                            'button_label' => 'Seja um visitante',
                            'button_url' => '#visitante',
                        ],
                    ],
                ],
            ],
        );

        SitePage::query()->firstOrCreate(
            ['slug' => 'sobre'],
            [
                'title' => 'Sobre a igreja',
                'type' => 'about',
                'status' => 'published',
                'menu_label' => 'Sobre',
                'menu_order' => 10,
                'show_in_menu' => true,
                'published_at' => now(),
                'blocks' => [
                    [
                        'type' => 'text',
                        'data' => [
                            'content' => '<h2>Nossa comunidade</h2><p>Somos uma igreja local comprometida com adoracao, cuidado pastoral, discipulado e servico a cidade.</p>',
                        ],
                    ],
                ],
            ],
        );

        BlogPost::query()->firstOrCreate(
            ['slug' => 'bem-vindo-ao-nosso-site'],
            [
                'title' => 'Bem-vindo ao nosso site',
                'author_name' => 'Equipe pastoral',
                'category' => 'Comunicados',
                'excerpt' => 'Um novo espaco para acompanhar a vida da igreja durante a semana.',
                'content' => '<p>Este blog reunira noticias, estudos, comunicados e materiais de apoio para nossa comunidade.</p>',
                'status' => 'published',
                'published_at' => now(),
            ],
        );

        foreach ($this->processFormTemplates() as $template) {
            ProcessForm::query()->firstOrCreate(
                ['slug' => $template['slug']],
                $template + [
                    'status' => 'draft',
                    'access_mode' => 'public',
                    'captcha_enabled' => true,
                    'allow_drafts' => false,
                    'confirmation_message' => 'Recebemos sua resposta. Obrigado!',
                ],
            );
        }
    }

    protected function processFormTemplates(): array
    {
        return [
            [
                'title' => 'Ficha de visitante',
                'slug' => 'ficha-de-visitante',
                'template_key' => 'visitor',
                'description' => 'Cadastro rapido para pessoas que visitaram ou desejam visitar a igreja.',
                'mappings' => [
                    'create_visitor_registration' => 'true',
                    'visitor_name_field' => 'nome',
                    'visitor_email_field' => 'email',
                    'visitor_phone_field' => 'telefone',
                ],
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome completo', true],
                    ['email', 'email', 'E-mail', false],
                    ['phone', 'telefone', 'Telefone/WhatsApp', true],
                    ['date_time', 'data_visita', 'Data desejada da visita', false],
                    ['short_text', 'culto_evento', 'Culto/evento', false],
                    ['number', 'pessoas', 'Quantidade de pessoas', false],
                ]),
            ],
            [
                'title' => 'Inscricao para batismo',
                'slug' => 'inscricao-para-batismo',
                'template_key' => 'baptism',
                'description' => 'Coleta dados de candidatos ao batismo.',
                'mappings' => ['member_tag' => 'Interessado em Batismo'],
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome completo', true],
                    ['email', 'email', 'E-mail', false],
                    ['phone', 'telefone', 'Telefone/WhatsApp', true],
                    ['date_time', 'data_nascimento', 'Data de nascimento', false],
                    ['single_choice', 'ja_membro', 'Ja e membro da igreja?', true, ['Sim', 'Nao']],
                    ['long_text', 'testemunho', 'Conte brevemente sua decisao', false],
                    ['agreement', 'lgpd', 'Concordo com o uso dos meus dados para esta inscricao', true],
                ]),
            ],
            [
                'title' => 'Inscricao para Escola de Lideres',
                'slug' => 'inscricao-escola-de-lideres',
                'template_key' => 'leaders_school',
                'description' => 'Inscricao e triagem para turmas de formacao.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome completo', true],
                    ['email', 'email', 'E-mail', true],
                    ['phone', 'telefone', 'Telefone/WhatsApp', true],
                    ['single_choice', 'participa_celula', 'Participa de celula?', true, ['Sim', 'Nao']],
                    ['long_text', 'ministerio', 'Ministerio ou area de interesse', false],
                ]),
            ],
            [
                'title' => 'Pedido de oracao',
                'slug' => 'pedido-de-oracao',
                'template_key' => 'prayer_request',
                'description' => 'Receba pedidos de oracao da igreja e visitantes.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome', false],
                    ['phone', 'telefone', 'Telefone/WhatsApp', false],
                    ['single_choice', 'tipo', 'Tipo de pedido', true, ['Pessoal', 'Familia', 'Saude', 'Gratidao', 'Outro']],
                    ['long_text', 'pedido', 'Pedido de oracao', true],
                    ['single_choice', 'pode_contatar', 'Podemos entrar em contato?', true, ['Sim', 'Nao']],
                ]),
            ],
            [
                'title' => 'Aconselhamento pastoral',
                'slug' => 'aconselhamento-pastoral',
                'template_key' => 'pastoral_counseling',
                'description' => 'Primeiro contato para acolhimento e encaminhamento pastoral.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome completo', true],
                    ['phone', 'telefone', 'Telefone/WhatsApp', true],
                    ['email', 'email', 'E-mail', false],
                    ['single_choice', 'urgencia', 'Nivel de urgencia', true, ['Baixa', 'Media', 'Alta']],
                    ['long_text', 'assunto', 'Como podemos ajudar?', true],
                ]),
            ],
            [
                'title' => 'Solicitacao de emprestimo de patrimonio',
                'slug' => 'solicitacao-emprestimo-patrimonio',
                'template_key' => 'asset_loan',
                'description' => 'Solicitacao de uso temporario de equipamentos e materiais.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Responsavel', true],
                    ['phone', 'telefone', 'Telefone', true],
                    ['long_text', 'itens', 'Itens solicitados', true],
                    ['date_time', 'retirada', 'Data de retirada', true],
                    ['date_time', 'devolucao', 'Data de devolucao', true],
                    ['long_text', 'finalidade', 'Finalidade do emprestimo', true],
                ]),
            ],
            [
                'title' => 'Cadastro para celula',
                'slug' => 'cadastro-para-celula',
                'template_key' => 'cell_signup',
                'description' => 'Interesse em participar de uma celula.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome completo', true],
                    ['phone', 'telefone', 'Telefone/WhatsApp', true],
                    ['short_text', 'bairro', 'Bairro', true],
                    ['multi_choice', 'dias', 'Melhores dias', false, ['Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado']],
                    ['long_text', 'observacoes', 'Observacoes', false],
                ]),
            ],
            [
                'title' => 'Formulario de oferta/dizimo online',
                'slug' => 'oferta-dizimo-online',
                'template_key' => 'online_offering',
                'description' => 'Registro simples de intencao de oferta ou dizimo online.',
                'fields' => $this->processFields([
                    ['short_text', 'nome', 'Nome', true],
                    ['email', 'email', 'E-mail', false],
                    ['number', 'valor', 'Valor', true],
                    ['single_choice', 'tipo', 'Tipo', true, ['Dizimo', 'Oferta', 'Missoes', 'Construcao']],
                    ['file_upload', 'comprovante', 'Comprovante', false],
                ]),
            ],
        ];
    }

    protected function processFields(array $fields): array
    {
        return collect($fields)->map(function (array $field): array {
            [$type, $key, $label, $required] = $field;
            $data = [
                'key' => $key,
                'label' => $label,
                'required' => $required,
            ];

            if (isset($field[4])) {
                $data['options'] = $field[4];
            }

            if ($type === 'agreement') {
                $data['agreement_text'] = $label;
            }

            return ['type' => $type, 'data' => $data];
        })->all();
    }
}
