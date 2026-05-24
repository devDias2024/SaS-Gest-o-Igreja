<?php

namespace App\Filament\Resources\SermonMedia\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SermonMediaTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('sermon.title')->label('Pregacao')->searchable()->sortable(),
            TextColumn::make('title')->label('Midia')->searchable()->placeholder('-'),
            TextColumn::make('media_type')->label('Tipo')->badge()->formatStateUsing(fn (?string $state): string => match ($state) {
                'audio' => 'Audio',
                'video' => 'Video',
                'live' => 'Ao vivo',
                default => 'Outro',
            }),
            TextColumn::make('source')->label('Origem')->badge(),
            IconColumn::make('is_primary')->label('Principal')->boolean(),
            IconColumn::make('allow_download')->label('Download')->boolean(),
        ])->filters([
            SelectFilter::make('media_type')->label('Tipo')->options([
                'audio' => 'Audio',
                'video' => 'Video',
                'live' => 'Ao vivo',
            ]),
            SelectFilter::make('source')->label('Origem')->options([
                'upload' => 'Upload',
                'youtube' => 'YouTube',
                'livepeer' => 'Livepeer',
                'external' => 'URL externa',
            ]),
        ])->recordActions([EditAction::make()])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
