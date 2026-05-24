<?php

namespace App\Filament\Resources\AssetLocations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AssetLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 2])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Tipo')
                            ->default('room')
                            ->required()
                            ->options([
                                'room' => 'Sala',
                                'warehouse' => 'Almoxarifado',
                                'office' => 'Escritorio',
                                'external' => 'Externo',
                            ]),
                        TextInput::make('responsible_name')
                            ->label('Responsavel')
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descricao')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
