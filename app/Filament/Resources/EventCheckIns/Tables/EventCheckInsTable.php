<?php

namespace App\Filament\Resources\EventCheckIns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventCheckInsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('checked_in_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('event.title')->label('Evento')->searchable()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('Convidado'),
                TextColumn::make('guest_name')->label('Convidado')->searchable()->toggleable(),
                TextColumn::make('method')->label('Metodo')->badge(),
                IconColumn::make('inside_geofence')->label('Geo')->boolean(),
                IconColumn::make('synced_from_offline')->label('Offline')->boolean(),
            ])
            ->filters([
                SelectFilter::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload(),
                SelectFilter::make('method')->label('Metodo')->options([
                    'manual' => 'Manual',
                    'qr_code' => 'QR Code',
                    'member_app' => 'App do membro',
                    'geofence' => 'Geofence',
                    'offline' => 'Offline',
                ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
