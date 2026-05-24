<?php

namespace App\Filament\Resources\Sermons\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SermonsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('preached_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
            TextColumn::make('title')->label('Pregacao')->searchable()->sortable(),
            TextColumn::make('category.name')->label('Categoria')->badge()->toggleable(),
            TextColumn::make('series.title')->label('Serie')->searchable()->toggleable(),
            TextColumn::make('preacher.name')->label('Pregador')->searchable()->toggleable(),
            TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn (?string $state): string => match ($state) {
                'draft' => 'Rascunho',
                'published' => 'Publicado',
                'archived' => 'Arquivado',
                default => 'Outro',
            }),
            TextColumn::make('view_count')->label('Views')->numeric()->sortable(),
            IconColumn::make('allow_download')->label('Download')->boolean()->toggleable(),
        ])->filters([
            SelectFilter::make('sermon_category_id')->label('Categoria')->relationship('category', 'name')->searchable()->preload(),
            SelectFilter::make('sermon_series_id')->label('Serie')->relationship('series', 'title')->searchable()->preload(),
            SelectFilter::make('preacher_id')->label('Pregador')->relationship('preacher', 'name')->searchable()->preload(),
            SelectFilter::make('status')->label('Status')->options([
                'draft' => 'Rascunho',
                'published' => 'Publicado',
                'archived' => 'Arquivado',
            ]),
            Filter::make('this_month')->label('Este mes')->query(fn (Builder $query): Builder => $query->whereMonth('preached_at', now()->month)->whereYear('preached_at', now()->year)),
        ])->recordActions([
            Action::make('publish')->label('Publicar')->icon('heroicon-o-check-circle')->visible(fn ($record): bool => $record->status !== 'published')->action(fn ($record) => $record->update(['status' => 'published'])),
            EditAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
