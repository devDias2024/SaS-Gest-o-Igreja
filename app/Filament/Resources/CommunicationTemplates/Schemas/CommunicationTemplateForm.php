<?php

namespace App\Filament\Resources\CommunicationTemplates\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CommunicationTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Template')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255)->live(onBlur: true)->afterStateUpdated(fn (string $state, callable $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)->maxLength(255),
                                        Select::make('channel')->label('Canal')->required()->options([
                                            'email' => 'E-mail',
                                            'sms' => 'SMS',
                                            'whatsapp' => 'WhatsApp',
                                            'push' => 'Push/App',
                                        ]),
                                        Select::make('category')->label('Categoria')->default('custom')->required()->options([
                                            'welcome' => 'Boas-vindas',
                                            'birthday' => 'Aniversario',
                                            'absence' => 'Ausencia',
                                            'event' => 'Evento',
                                            'announcement' => 'Aviso',
                                            'custom' => 'Personalizado',
                                        ]),
                                        Select::make('communication_provider_id')->label('Provedor')->relationship('provider', 'name')->searchable()->preload(),
                                        Toggle::make('is_active')->label('Ativo')->default(true),
                                    ]),
                            ]),
                        Tab::make('Conteudo')
                            ->schema([
                                TextInput::make('subject')->label('Assunto')->maxLength(255)->columnSpanFull(),
                                Textarea::make('body')->label('Mensagem')->required()->rows(10)->columnSpanFull(),
                            ]),
                        Tab::make('Personalizacao')
                            ->schema([
                                KeyValue::make('variables')->label('Variaveis disponiveis')->keyLabel('Variavel')->valueLabel('Exemplo')->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
