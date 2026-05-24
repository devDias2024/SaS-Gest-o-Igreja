<?php

namespace App\Filament\Resources\PastoralVisits\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PastoralVisitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')->label('Agendada')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->placeholder('Nao informado'),
                TextColumn::make('cellGroup.name')->label('Celula')->searchable()->toggleable(),
                TextColumn::make('pastor.full_name')->label('Pastor/lider')->searchable()->toggleable(),
                TextColumn::make('visit_type')->label('Tipo')->badge(),
                TextColumn::make('status')->label('Status')->badge(),
                IconColumn::make('requires_follow_up')->label('Retorno')->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'scheduled' => 'Agendada',
                    'completed' => 'Realizada',
                    'canceled' => 'Cancelada',
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
