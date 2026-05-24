<?php

namespace App\Filament\Resources\SermonSeries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SermonSeriesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Serie')->searchable()->sortable(),
            TextColumn::make('starts_at')->label('Inicio')->date('d/m/Y')->sortable(),
            TextColumn::make('ends_at')->label('Fim')->date('d/m/Y')->sortable(),
            TextColumn::make('sermons_count')->label('Pregacoes')->counts('sermons')->sortable(),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
