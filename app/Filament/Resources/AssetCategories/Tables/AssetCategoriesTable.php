<?php

namespace App\Filament\Resources\AssetCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AssetCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'asset' => 'Patrimonio',
                        'stock' => 'Estoque',
                        'both' => 'Ambos',
                        default => 'Outro',
                    }),
                TextColumn::make('assets_count')->label('Itens')->counts('assets')->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'asset' => 'Patrimonio',
                    'stock' => 'Estoque',
                    'both' => 'Ambos',
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
