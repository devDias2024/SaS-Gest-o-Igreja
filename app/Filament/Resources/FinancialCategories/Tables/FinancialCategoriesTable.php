<?php

namespace App\Filament\Resources\FinancialCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FinancialCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('type')->label('Tipo')->badge()->formatStateUsing(fn (?string $state): string => $state === 'expense' ? 'Despesa' : 'Receita'),
                TextColumn::make('transactions_count')->label('Lancamentos')->counts('transactions')->sortable(),
                IconColumn::make('is_active')->label('Ativa')->boolean(),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipo')->options([
                    'income' => 'Receita',
                    'expense' => 'Despesa',
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
