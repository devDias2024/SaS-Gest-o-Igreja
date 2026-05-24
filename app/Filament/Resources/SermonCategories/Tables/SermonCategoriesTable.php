<?php

namespace App\Filament\Resources\SermonCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SermonCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nome')->searchable()->sortable(),
            TextColumn::make('slug')->label('Slug')->searchable()->toggleable(),
            TextColumn::make('sermons_count')->label('Pregacoes')->counts('sermons')->sortable(),
            IconColumn::make('is_active')->label('Ativa')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
