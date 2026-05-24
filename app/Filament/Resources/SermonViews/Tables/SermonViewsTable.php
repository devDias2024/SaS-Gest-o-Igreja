<?php

namespace App\Filament\Resources\SermonViews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SermonViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('viewed_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
            TextColumn::make('sermon.title')->label('Pregacao')->searchable()->sortable(),
            TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('-'),
            TextColumn::make('viewer_name')->label('Visitante')->searchable()->placeholder('-'),
            TextColumn::make('source')->label('Origem')->badge(),
            TextColumn::make('watched_seconds')->label('Tempo (s)')->numeric()->sortable(),
        ])->filters([
            SelectFilter::make('sermon_id')->label('Pregacao')->relationship('sermon', 'title')->searchable()->preload(),
            SelectFilter::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
            Filter::make('this_month')->label('Este mes')->query(fn (Builder $query): Builder => $query->whereMonth('viewed_at', now()->month)->whereYear('viewed_at', now()->year)),
            Filter::make('last_30_days')->label('Ultimos 30 dias')->query(fn (Builder $query): Builder => $query->where('viewed_at', '>=', now()->subDays(30))),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
