<?php

namespace App\Filament\Resources\VolunteerRoles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class VolunteerRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Funcao da escala')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                        TextInput::make('default_slots')->label('Vagas padrao')->numeric()->default(1),
                                        TextInput::make('color')->label('Cor')->default('gray')->maxLength(20),
                                        Toggle::make('rotates_automatically')->label('Rotacao automatica')->default(true),
                                        Toggle::make('is_active')->label('Ativa')->default(true),
                                    ]),
                            ]),
                        Tab::make('Descricao')
                            ->schema([
                                Textarea::make('description')->label('Descricao')->rows(5)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
