<?php

namespace App\Filament\Resources\CommunicationCampaigns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CommunicationCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('type')->label('Tipo')->badge()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('scheduled_at')->label('Agendada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('estimated_recipients')->label('Estimados')->sortable(),
                TextColumn::make('sent_count')->label('Enviadas')->sortable(),
                TextColumn::make('opened_count')->label('Aberturas')->sortable(),
                TextColumn::make('clicked_count')->label('Cliques')->sortable(),
                TextColumn::make('open_rate')->label('Taxa abertura')->state(fn ($record): string => $record->openRate().'%'),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'draft' => 'Rascunho',
                    'scheduled' => 'Agendada',
                    'sending' => 'Enviando',
                    'sent' => 'Enviada',
                    'paused' => 'Pausada',
                    'cancelled' => 'Cancelada',
                ]),
                SelectFilter::make('type')->label('Tipo')->options([
                    'announcement' => 'Aviso em massa',
                    'event' => 'Evento',
                    'birthday' => 'Aniversario',
                    'absence' => 'Ausencia',
                    'custom' => 'Personalizada',
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
