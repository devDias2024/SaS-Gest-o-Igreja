<?php

namespace App\Filament\Resources\EventLocations\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class EventLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Local do evento')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255),
                                        TextInput::make('capacity')->label('Capacidade')->numeric(),
                                        Toggle::make('is_active')->label('Ativo')->default(true),
                                        Textarea::make('address')->label('Endereco')->rows(2)->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Geofence')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('latitude')->label('Latitude')->numeric(),
                                        TextInput::make('longitude')->label('Longitude')->numeric(),
                                        TextInput::make('geofence_radius_meters')->label('Raio geofence (m)')->numeric()->default(100),
                                        Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
