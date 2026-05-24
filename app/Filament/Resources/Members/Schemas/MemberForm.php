<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\Enums\CepFieldMode;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;
use Leandrocfe\FilamentPtbrFormFields\Providers\ViaCepProvider;
use Relaticle\CustomFields\Facades\CustomFields;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Cadastro do membro')
                    ->tabs([
                        Tab::make('Principal')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2, 'xl' => 3])
                                    ->schema([
                                        TextInput::make('full_name')
                                            ->label('Nome completo')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('preferred_name')
                                            ->label('Nome de uso')
                                            ->maxLength(255),
                                        DatePicker::make('birth_date')
                                            ->label('Nascimento')
                                            ->native(false),
                                        Select::make('gender')
                                            ->label('Gênero')
                                            ->options([
                                                'female' => 'Feminino',
                                                'male' => 'Masculino',
                                                'other' => 'Outro',
                                            ]),
                                        Select::make('marital_status')
                                            ->label('Estado civil')
                                            ->options([
                                                'single' => 'Solteiro(a)',
                                                'married' => 'Casado(a)',
                                                'divorced' => 'Divorciado(a)',
                                                'widowed' => 'Viúvo(a)',
                                            ]),
                                    ]),
                                Fieldset::make('Contato')
                                    ->schema([
                                        TextInput::make('email')
                                            ->label('E-mail')
                                            ->email()
                                            ->maxLength(255),
                                        PhoneNumber::make('phone')
                                            ->label('Telefone')
                                            ->maxLength(255),
                                        PhoneNumber::make('whatsapp')
                                            ->label('WhatsApp')
                                            ->maxLength(255),
                                    ])
                                    ->columns(['default' => 1, 'md' => 3]),
                                Fieldset::make('Documento')
                                    ->schema([
                                        Select::make('document_type')
                                            ->label('Tipo')
                                            ->options([
                                                'cpf' => 'CPF',
                                                'rg' => 'RG',
                                                'passport' => 'Passaporte',
                                                'other' => 'Outro',
                                            ]),
                                        Document::make('document_number')
                                            ->label('Número')
                                            ->dynamic()
                                            ->dehydrateMask()
                                            ->maxLength(255),
                                    ])
                                    ->columns(['default' => 1, 'md' => 2]),
                            ]),

                        Tab::make('Igreja')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('member_category_id')
                                            ->label('Categoria')
                                            ->relationship('category', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                                TextInput::make('color')->label('Cor')->default('gray')->maxLength(20),
                                                Textarea::make('description')->label('Descrição')->rows(3),
                                            ]),
                                        Select::make('tags')
                                            ->label('Tags')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                                TextInput::make('color')->label('Cor')->default('gray')->maxLength(20),
                                                Textarea::make('description')->label('Descrição')->rows(3),
                                            ]),
                                        DatePicker::make('conversion_date')
                                            ->label('Data de conversão')
                                            ->native(false),
                                        DatePicker::make('baptism_date')
                                            ->label('Data de batismo')
                                            ->native(false),
                                        TextInput::make('ministry_role')
                                            ->label('Cargo ou ministério')
                                            ->maxLength(255),
                                        Select::make('spiritual_status')
                                            ->label('Situação')
                                            ->default('active')
                                            ->required()
                                            ->options([
                                                'active' => 'Ativo',
                                                'visitor' => 'Visitante',
                                                'away' => 'Afastado',
                                                'transferred' => 'Transferido',
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Endereço')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 6])
                                    ->schema([
                                        Cep::make('address_zip_code')
                                            ->label('CEP')
                                            ->mode(CepFieldMode::SUFFIX)
                                            ->api(ViaCepProvider::class, function ($set, $response) {
                                                if ($response) {
                                                    $set('address_street', $response['logradouro'] ?? null);
                                                    $set('address_complement', $response['complemento'] ?? null);
                                                    $set('address_neighborhood', $response['bairro'] ?? null);
                                                    $set('address_city', $response['localidade'] ?? null);
                                                    $set('address_state', $response['uf'] ?? null);
                                                }
                                            })
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('address_street')
                                            ->label('Rua')
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 3]),
                                        TextInput::make('address_number')
                                            ->label('Número')
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 1]),
                                        TextInput::make('address_complement')
                                            ->label('Complemento')
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('address_neighborhood')
                                            ->label('Bairro')
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('address_city')
                                            ->label('Cidade')
                                            ->maxLength(255)
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('address_state')
                                            ->label('UF')
                                            ->maxLength(2)
                                            ->columnSpan(['md' => 1]),
                                        TextInput::make('latitude')
                                            ->label('Latitude')
                                            ->numeric()
                                            ->columnSpan(['md' => 2]),
                                        TextInput::make('longitude')
                                            ->label('Longitude')
                                            ->numeric()
                                            ->columnSpan(['md' => 2]),
                                    ]),
                            ]),

                        Tab::make('Família')
                            ->schema([
                                Repeater::make('familyLinks')
                                    ->label('Vínculos familiares')
                                    ->relationship()
                                    ->addActionLabel('Adicionar vínculo')
                                    ->schema([
                                        Select::make('related_member_id')
                                            ->label('Membro vinculado')
                                            ->relationship('relatedMember', 'full_name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('relationship_type')
                                            ->label('Parentesco')
                                            ->required()
                                            ->options([
                                                'spouse' => 'Cônjuge',
                                                'child' => 'Filho(a)',
                                                'parent' => 'Pai/Mãe',
                                                'sibling' => 'Irmão/Irmã',
                                                'other' => 'Outro',
                                            ]),
                                        Toggle::make('is_emergency_contact')
                                            ->label('Contato de emergência')
                                            ->inline(false),
                                        Textarea::make('notes')
                                            ->label('Observações')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(['default' => 1, 'md' => 2])
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Arquivos e notas')
                            ->schema([
                                FileUpload::make('photos')
                                    ->label('Fotos')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->disk('public')
                                    ->directory('members/photos')
                                    ->imageEditor(),
                                Textarea::make('notes')
                                    ->label('Observações gerais')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Campos personalizados')
                            ->schema([
                                CustomFields::form()
                                    ->forSchema($schema)
                                    ->build(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
