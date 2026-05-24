<?php

namespace App\Filament\Resources\PastoralCounselingSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PastoralCounselingSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('case.title')->label('Prontuario')->searchable(),
                TextColumn::make('case.member.full_name')->label('Aconselhado')->searchable(),
                TextColumn::make('pastor.name')->label('Pastor')->searchable(),
                TextColumn::make('duration_minutes')->label('Duracao')->suffix(' min'),
                TextColumn::make('location_type')->label('Tipo')->badge(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('reminder_at')->label('Lembrete')->dateTime('d/m/Y H:i')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'scheduled' => 'Agendada',
                    'completed' => 'Realizada',
                    'missed' => 'Nao compareceu',
                    'canceled' => 'Cancelada',
                ]),
                SelectFilter::make('location_type')->label('Tipo')->options([
                    'in_person' => 'Presencial',
                    'online' => 'Online',
                    'phone' => 'Telefone',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('scheduled_at', 'desc');
    }
}
