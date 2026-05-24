<?php

namespace App\Filament\Resources\CommunicationAutomations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationAutomationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('trigger')->label('Gatilho')->badge()->sortable(),
                TextColumn::make('template.name')->label('Template')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('delay_minutes')->label('Atraso')->suffix(' min')->sortable(),
                TextColumn::make('run_count')->label('Execucoes')->sortable(),
                TextColumn::make('last_run_at')->label('Ultima execucao')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'paused' => 'Pausada',
                    'archived' => 'Arquivada',
                ]),
                SelectFilter::make('trigger')->label('Gatilho')->options([
                    'member_created' => 'Novo membro',
                    'birthday' => 'Aniversario',
                    'absence_3_weeks' => 'Faltou 3 semanas',
                    'event_registered' => 'Inscricao em evento',
                    'pledge_late' => 'Promessa em atraso',
                    'custom' => 'Personalizado',
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
