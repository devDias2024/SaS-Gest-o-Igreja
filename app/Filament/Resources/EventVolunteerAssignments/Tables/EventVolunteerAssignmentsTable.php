<?php

namespace App\Filament\Resources\EventVolunteerAssignments\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventVolunteerAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.starts_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('event.title')->label('Evento')->searchable(),
                TextColumn::make('role.name')->label('Funcao')->badge()->searchable(),
                TextColumn::make('member.full_name')->label('Voluntario')->searchable()->placeholder('Em aberto'),
                TextColumn::make('slot_number')->label('Vaga'),
                TextColumn::make('status')->label('Status')->badge(),
                IconColumn::make('auto_assigned')->label('Auto')->boolean(),
                IconColumn::make('notified_at')->label('Avisado')->boolean()->state(fn ($record): bool => filled($record->notified_at)),
            ])
            ->filters([
                SelectFilter::make('church_event_id')->label('Evento')->relationship('event', 'title')->searchable()->preload(),
                SelectFilter::make('volunteer_role_id')->label('Funcao')->relationship('role', 'name')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'scheduled' => 'Escalado',
                    'confirmed' => 'Confirmado',
                    'declined' => 'Recusou',
                    'replaced' => 'Substituido',
                ]),
            ])
            ->recordActions([
                Action::make('markNotified')
                    ->label('Marcar aviso')
                    ->icon('heroicon-o-bell')
                    ->action(fn ($record) => $record->update(['notified_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
