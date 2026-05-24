<?php

namespace App\Filament\Resources\ProcessForms\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProcessFormsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Formulario')->searchable()->sortable(),
                TextColumn::make('slug')->label('Link')->searchable()->copyable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('access_mode')->label('Acesso')->badge()->sortable(),
                TextColumn::make('submissions_count')->label('Respostas')->counts('submissions')->sortable(),
                TextColumn::make('published_at')->label('Publicado')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'draft' => 'Rascunho',
                    'published' => 'Publicado',
                    'paused' => 'Pausado',
                    'archived' => 'Arquivado',
                ]),
                SelectFilter::make('access_mode')->label('Acesso')->options([
                    'public' => 'Publico',
                    'members' => 'Membros',
                ]),
            ])
            ->recordActions([
                Action::make('dashboard')
                    ->label('Dashboard')
                    ->url(fn ($record) => route('process-forms.dashboard', $record))
                    ->openUrlInNewTab(),
                Action::make('preview')
                    ->label('Previa')
                    ->url(fn ($record) => route('process-forms.preview', $record))
                    ->openUrlInNewTab(),
                Action::make('public_link')
                    ->label('Abrir')
                    ->url(fn ($record) => route('process-forms.show', $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
