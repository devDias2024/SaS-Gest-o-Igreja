<?php

namespace App\Filament\Resources\PastoralEmergencyAlerts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PastoralEmergencyAlertsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('triggered_at')->label('Acionada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('case.title')->label('Prontuario')->searchable(),
                TextColumn::make('triggeredBy.name')->label('Acionada por')->searchable(),
                TextColumn::make('contact_phone')->label('Contato')->searchable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('resolved_at')->label('Resolvida')->dateTime('d/m/Y H:i')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'open' => 'Aberta',
                    'in_progress' => 'Em atendimento',
                    'resolved' => 'Resolvida',
                    'canceled' => 'Cancelada',
                ]),
            ])
            ->recordActions([
                Action::make('resolve')
                    ->label('Resolver')
                    ->visible(fn ($record) => $record->status !== 'resolved')
                    ->action(fn ($record) => $record->update(['status' => 'resolved', 'resolved_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('triggered_at', 'desc');
    }
}
