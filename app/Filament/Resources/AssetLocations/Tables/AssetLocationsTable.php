<?php

namespace App\Filament\Resources\AssetLocations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetLocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Local')->searchable()->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'room' => 'Sala',
                        'warehouse' => 'Almoxarifado',
                        'office' => 'Escritorio',
                        'external' => 'Externo',
                        default => 'Outro',
                    }),
                TextColumn::make('responsible_name')->label('Responsavel')->searchable()->placeholder('-'),
                TextColumn::make('assets_count')->label('Itens')->counts('assets')->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'room' => 'Sala',
                    'warehouse' => 'Almoxarifado',
                    'office' => 'Escritorio',
                    'external' => 'Externo',
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
