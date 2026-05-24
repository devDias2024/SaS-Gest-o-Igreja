<?php

namespace App\Filament\Resources\MemberCredentialTemplates\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MemberCredentialTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Modelo da credencial')
                ->tabs([
                    Tab::make('Identidade')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                TextInput::make('name')->label('Nome do modelo')->required()->maxLength(255),
                                Toggle::make('is_active')->label('Modelo ativo')->default(true),
                                TextInput::make('church_name')->label('Nome da igreja')->maxLength(255),
                                TextInput::make('authority_name')->label('Nome da autoridade')->maxLength(255),
                                TextInput::make('authority_title')->label('Cargo da autoridade')->maxLength(255),
                                TextInput::make('default_validity_months')->label('Validade padrao (meses)')->numeric()->default(12)->required(),
                            ]),
                        ]),
                    Tab::make('Aparencia')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                FileUpload::make('church_logo')
                                    ->label('Logo da igreja')
                                    ->helperText('Use preferencialmente uma imagem PNG com fundo transparente.')
                                    ->disk('public')
                                    ->directory('credentials/logos')
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpanFull(),
                                FileUpload::make('front_background')
                                    ->label('Imagem de fundo da frente')
                                    ->disk('public')
                                    ->directory('credentials/backgrounds')
                                    ->image()
                                    ->imageEditor(),
                                FileUpload::make('back_background')
                                    ->label('Imagem de fundo do verso')
                                    ->disk('public')
                                    ->directory('credentials/backgrounds')
                                    ->image()
                                    ->imageEditor(),
                                ColorPicker::make('background_color')->label('Cor de fundo')->default('#d97706')->required(),
                                ColorPicker::make('text_color')->label('Cor da letra')->default('#ffffff')->required(),
                                Select::make('border_shape')->label('Formato da borda')->default('rounded')->options([
                                    'rounded' => 'Redonda',
                                    'square' => 'Quadrada',
                                ])->required(),
                                Select::make('photo_shape')->label('Formato da foto')->default('round')->options([
                                    'round' => 'Redonda',
                                    'square' => 'Quadrada',
                                    'rectangle' => 'Retangular',
                                ])->required(),
                            ]),
                        ]),
                    Tab::make('Conteudo')
                        ->schema([
                            Fieldset::make('Dados visiveis')->schema([
                                Select::make('document_type')->label('Documento exibido')->default('member')->options([
                                    'member' => 'Documento do cadastro',
                                    'rg' => 'RG',
                                    'cpf' => 'CPF',
                                    'none' => 'Nao exibir',
                                ])->required(),
                                Toggle::make('show_holder_signature')->label('Assinatura do portador')->default(true),
                                Toggle::make('show_authority_signature')->label('Assinatura da autoridade')->default(true),
                            ])->columns(['default' => 1, 'md' => 3]),
                            Textarea::make('back_description')
                                ->label('Descricao no verso')
                                ->placeholder('Esta credencial identifica seu portador como membro da comunidade local.')
                                ->rows(4)
                                ->columnSpanFull(),
                        ]),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),
        ]);
    }
}
