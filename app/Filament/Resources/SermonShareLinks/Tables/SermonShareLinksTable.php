<?php

namespace App\Filament\Resources\SermonShareLinks\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SermonShareLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sermon.title')->label('Pregacao')->searchable()->sortable(),
            TextColumn::make('label')->label('Identificacao')->searchable()->placeholder('-'),
            TextColumn::make('token')->label('Token')->copyable()->toggleable(),
            TextColumn::make('url')->label('Link')->state(fn ($record): string => route('sermons.share.show', $record->token))->copyable(),
            TextColumn::make('expires_at')->label('Expira')->dateTime('d/m/Y H:i')->sortable()->placeholder('-'),
            TextColumn::make('view_count')->label('Views')->numeric()->sortable(),
            IconColumn::make('allow_download')->label('Download')->boolean(),
        ])->recordActions([
            Action::make('open')->label('Abrir')->icon('heroicon-o-arrow-top-right-on-square')->url(fn ($record): string => route('sermons.share.show', $record->token), true),
            EditAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
