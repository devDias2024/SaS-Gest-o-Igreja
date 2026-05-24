<?php

namespace App\Filament\Resources\PanelSettings\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PanelSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Configuracao do painel')
                ->tabs([
                    Tab::make('Identidade')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                TextInput::make('panel_name')
                                    ->label('Nome do painel')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                FileUpload::make('panel_logo')
                                    ->label('Logo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('panel/branding'),
                                FileUpload::make('panel_logo_dark')
                                    ->label('Logo no modo escuro')
                                    ->image()
                                    ->disk('public')
                                    ->directory('panel/branding'),
                                FileUpload::make('favicon')
                                    ->label('Icone do navegador')
                                    ->image()
                                    ->disk('public')
                                    ->directory('panel/branding'),
                            ]),
                        ]),
                    Tab::make('Aparencia')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                ColorPicker::make('primary_color')
                                    ->label('Cor principal')
                                    ->default('#f59e0b')
                                    ->required(),
                                Select::make('visual_style')
                                    ->label('Estilo')
                                    ->options([
                                        'awin' => 'Awin',
                                        'soft' => 'Suave',
                                        'compact' => 'Compacto',
                                    ])
                                    ->default('awin')
                                    ->required(),
                                Select::make('font_family')
                                    ->label('Fonte')
                                    ->options([
                                        'Instrument Sans' => 'Instrument Sans',
                                        'Inter' => 'Inter',
                                        'Poppins' => 'Poppins',
                                        'Roboto' => 'Roboto',
                                        'Montserrat' => 'Montserrat',
                                        'Nunito Sans' => 'Nunito Sans',
                                    ])
                                    ->default('Instrument Sans')
                                    ->searchable()
                                    ->required(),
                                Select::make('theme_mode')
                                    ->label('Modo inicial')
                                    ->options([
                                        'system' => 'Automatico do dispositivo',
                                        'light' => 'Claro',
                                        'dark' => 'Escuro',
                                    ])
                                    ->default('dark')
                                    ->required(),
                                Toggle::make('allow_dark_mode')
                                    ->label('Permitir modo escuro')
                                    ->default(true),
                            ]),
                        ]),
                    Tab::make('Navegacao')
                        ->schema([
                            Grid::make(['default' => 1, 'md' => 2])->schema([
                                Select::make('sidebar_width')
                                    ->label('Largura da sidebar')
                                    ->options([
                                        '16rem' => 'Compacta',
                                        '18rem' => 'Media',
                                        '20rem' => 'Confortavel',
                                        '22rem' => 'Ampla',
                                    ])
                                    ->default('20rem')
                                    ->required(),
                                Toggle::make('collapsible_groups')
                                    ->label('Grupos recolhiveis')
                                    ->default(true),
                                Toggle::make('collapsible_sidebar')
                                    ->label('Sidebar recolhivel no desktop')
                                    ->default(false),
                                Toggle::make('top_navigation')
                                    ->label('Navegacao no topo')
                                    ->default(false),
                            ]),
                        ]),
                ])
                ->persistTabInQueryString()
                ->columnSpanFull(),
        ]);
    }
}
