<?php

namespace App\Filament\Resources\ProcessForms\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProcessFormForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Construtor de formulario')->tabs([
                Tab::make('Dados')->schema([
                    Section::make('Identificacao')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('title')
                                ->label('Nome do formulario')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug((string) $state)))
                                ->maxLength(255),
                            TextInput::make('slug')->label('Link amigavel')->required()->maxLength(255)->unique(ignoreRecord: true),
                            Select::make('template_key')->label('Template')->options(self::templateOptions())->searchable(),
                            Select::make('status')->label('Status')->default('draft')->required()->options([
                                'draft' => 'Rascunho',
                                'published' => 'Publicado',
                                'paused' => 'Pausado',
                                'archived' => 'Arquivado',
                            ]),
                            Select::make('access_mode')->label('Acesso')->default('public')->required()->options([
                                'public' => 'Publico com link',
                                'members' => 'Somente membros logados',
                            ]),
                            DateTimePicker::make('published_at')->label('Publicado em')->native(false),
                            Textarea::make('description')->label('Descricao')->rows(4)->columnSpanFull(),
                        ]),
                    ]),
                    Section::make('Publicacao e limites')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            DateTimePicker::make('starts_at')->label('Inicia em')->native(false),
                            DateTimePicker::make('ends_at')->label('Encerra em')->native(false),
                            TextInput::make('response_limit')->label('Limite de respostas')->numeric()->minValue(1),
                            Toggle::make('captcha_enabled')->label('Protecao antispam')->default(true),
                            Toggle::make('allow_drafts')->label('Permitir rascunho')->default(false),
                            TextInput::make('redirect_url')->label('Redirecionar apos envio')->url()->maxLength(255),
                            Textarea::make('confirmation_message')->label('Mensagem de confirmacao')->rows(3)->columnSpanFull(),
                        ]),
                    ]),
                ]),
                Tab::make('Campos')->schema([
                    Section::make('Construtor')->description('Arraste os blocos para mudar a ordem do formulario publico.')->schema([
                        Builder::make('fields')
                            ->label('Campos do formulario')
                            ->blocks(self::fieldBlocks())
                            ->collapsible()
                            ->blockNumbers(false)
                            ->columnSpanFull(),
                    ]),
                ]),
                Tab::make('Automacoes')->schema([
                    Section::make('Mapeamento com membros e visitantes')->schema([
                        Grid::make(['default' => 1, 'md' => 3])->schema([
                            Toggle::make('mappings.create_visitor_registration')->label('Criar visitante automaticamente'),
                            Toggle::make('mappings.create_or_update_member')->label('Criar/atualizar membro'),
                            TextInput::make('mappings.member_tag')->label('Tag para membro')->placeholder('Interessado em Batismo'),
                            TextInput::make('mappings.visitor_name_field')->label('Campo nome visitante')->placeholder('nome'),
                            TextInput::make('mappings.visitor_email_field')->label('Campo e-mail visitante')->placeholder('email'),
                            TextInput::make('mappings.visitor_phone_field')->label('Campo telefone visitante')->placeholder('telefone'),
                            TextInput::make('mappings.member_name_field')->label('Campo nome membro')->placeholder('nome'),
                            TextInput::make('mappings.member_email_field')->label('Campo e-mail membro')->placeholder('email'),
                            TextInput::make('mappings.member_phone_field')->label('Campo telefone membro')->placeholder('telefone'),
                            TextInput::make('mappings.cell_group_name')->label('Adicionar a celula/lista')->placeholder('Lista de espera da celula')->columnSpanFull(),
                        ]),
                    ]),
                    Section::make('Depois da resposta')->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            TextInput::make('automations.confirmation_email_subject')->label('Assunto do e-mail de confirmacao'),
                            TextInput::make('automations.notify_email')->label('Notificar lider/pastor por e-mail')->email(),
                            Textarea::make('automations.confirmation_email_body')->label('Texto do e-mail de confirmacao')->rows(4)->columnSpanFull(),
                            Textarea::make('automations.whatsapp_message')->label('Mensagem WhatsApp automatica')->rows(3)->columnSpanFull(),
                        ]),
                    ]),
                ]),
                Tab::make('Webhooks')->schema([
                    Section::make('Integracoes externas')->schema([
                        Repeater::make('webhooks')
                            ->label('Webhooks')
                            ->schema([
                                TextInput::make('name')->label('Nome')->maxLength(255),
                                TextInput::make('url')->label('URL')->url()->required(),
                                Select::make('method')->label('Metodo')->default('POST')->options([
                                    'POST' => 'POST',
                                    'PUT' => 'PUT',
                                    'PATCH' => 'PATCH',
                                ]),
                                TextInput::make('secret')->label('Segredo')->password()->revealable(),
                                Toggle::make('is_active')->label('Ativo')->default(true),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }

    protected static function fieldBlocks(): array
    {
        return [
            self::fieldBlock('short_text', 'Texto curto', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('long_text', 'Texto longo', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('number', 'Numero', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('email', 'E-mail', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('phone', 'Telefone', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('document', 'CPF/CNPJ', [TextInput::make('placeholder')->label('Placeholder')]),
            self::fieldBlock('date_time', 'Data e hora'),
            self::fieldBlock('single_choice', 'Selecao unica', [
                Select::make('display')->label('Exibir como')->default('dropdown')->options(['dropdown' => 'Dropdown', 'radio' => 'Radio']),
                TagsInput::make('options')->label('Opcoes')->placeholder('Adicionar opcao'),
            ]),
            self::fieldBlock('multi_choice', 'Selecao multipla', [
                TagsInput::make('options')->label('Opcoes')->placeholder('Adicionar opcao'),
            ]),
            self::fieldBlock('file_upload', 'Upload de arquivo', [
                TagsInput::make('accepted_types')->label('Tipos aceitos')->placeholder('image/*, application/pdf'),
            ]),
            self::fieldBlock('signature', 'Assinatura digital'),
            self::fieldBlock('agreement', 'Concordancia LGPD/termos', [
                Textarea::make('agreement_text')->label('Texto da concordancia')->rows(3),
            ]),
        ];
    }

    protected static function fieldBlock(string $name, string $label, array $extra = []): Block
    {
        return Block::make($name)
            ->label($label)
            ->schema(array_merge([
                Grid::make(['default' => 1, 'md' => 2])->schema([
                    TextInput::make('key')->label('Chave do campo')->helperText('Ex: nome, telefone, data_batismo')->required()->maxLength(80),
                    TextInput::make('label')->label('Rotulo')->required()->maxLength(255),
                    Toggle::make('required')->label('Obrigatorio'),
                    TextInput::make('help_text')->label('Texto de ajuda')->maxLength(255),
                    TextInput::make('conditional_field')->label('Mostrar se o campo')->maxLength(80),
                    TextInput::make('conditional_value')->label('For igual a')->maxLength(255),
                ]),
            ], $extra));
    }

    protected static function templateOptions(): array
    {
        return [
            'visitor' => 'Ficha de visitante',
            'baptism' => 'Inscricao para batismo',
            'leaders_school' => 'Inscricao para Escola de Lideres',
            'prayer_request' => 'Pedido de oracao',
            'pastoral_counseling' => 'Aconselhamento pastoral',
            'asset_loan' => 'Solicitacao de emprestimo de patrimonio',
            'cell_signup' => 'Cadastro para celula',
            'online_offering' => 'Formulario de oferta/dizimo online',
        ];
    }
}
