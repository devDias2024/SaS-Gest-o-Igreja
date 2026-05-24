<?php

namespace App\Filament\Resources\StockMovements\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockMovementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('movement_date')->label('Data')->date('d/m/Y')->sortable(),
                TextColumn::make('asset.code')->label('Codigo')->searchable()->toggleable(),
                TextColumn::make('asset.name')->label('Item')->searchable()->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'in' => 'Entrada',
                        'out' => 'Saida',
                        'transfer' => 'Transferencia',
                        'adjustment' => 'Ajuste',
                        default => 'Outro',
                    }),
                TextColumn::make('quantity')->label('Quantidade')->numeric()->sortable(),
                TextColumn::make('unit_cost')->label('Custo unitario')->money('BRL')->sortable()->toggleable(),
                TextColumn::make('fromLocation.name')->label('Origem')->toggleable()->placeholder('-'),
                TextColumn::make('toLocation.name')->label('Destino')->toggleable()->placeholder('-'),
                TextColumn::make('reference')->label('Referencia')->searchable()->toggleable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'in' => 'Entrada',
                    'out' => 'Saida',
                    'transfer' => 'Transferencia',
                    'adjustment' => 'Ajuste',
                ]),
                SelectFilter::make('asset_id')->label('Item')->relationship('asset', 'name')->searchable()->preload(),
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
