<?php

namespace App\Filament\Resources\EventCheckIns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class EventCheckInForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Presenca')
                    ->tabs([
                        Tab::make('Check-in')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload()->required(),
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        TextInput::make('guest_name')->label('Convidado')->maxLength(255),
                                        Select::make('method')->label('Metodo')->default('manual')->required()->options([
                                            'manual' => 'Manual',
                                            'qr_code' => 'QR Code',
                                            'member_app' => 'App do membro',
                                            'geofence' => 'Geofence',
                                            'offline' => 'Offline',
                                        ]),
                                        DateTimePicker::make('checked_in_at')->label('Check-in em')->default(now())->required()->native(false),
                                    ]),
                            ]),
                        Tab::make('Localizacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('latitude')->label('Latitude')->numeric(),
                                        TextInput::make('longitude')->label('Longitude')->numeric(),
                                        Toggle::make('inside_geofence')->label('Dentro do raio')->inline(false),
                                        TextInput::make('device_id')->label('Dispositivo')->maxLength(255),
                                        Toggle::make('synced_from_offline')->label('Sincronizado offline')->inline(false),
                                        Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
