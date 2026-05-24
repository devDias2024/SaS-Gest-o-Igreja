<?php

namespace App\Filament\Resources\Funds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FundsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('opening_balance')->label('Saldo inicial')->money('BRL')->sortable(),
                TextColumn::make('balance')->label('Saldo atual')->state(fn ($record): float => $record->balance())->money('BRL'),
                IconColumn::make('is_restricted')->label('Restrito')->boolean(),
                IconColumn::make('accepts_online_donations')->label('Online')->boolean(),
            ])
            ->filters([
                //
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
