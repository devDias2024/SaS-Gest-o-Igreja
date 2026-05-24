<?php

namespace App\Filament\Resources\VisitorRegistrations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisitorRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Cadastro')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('phone')->label('Telefone')->searchable(),
                TextColumn::make('planned_visit_on')->label('Visita')->date('d/m/Y')->sortable(),
                TextColumn::make('preferred_service')->label('Culto/evento')->searchable()->limit(35),
                TextColumn::make('party_size')->label('Pessoas')->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'new' => 'Novo',
                    'contacted' => 'Contatado',
                    'scheduled' => 'Agendado',
                    'attended' => 'Compareceu',
                    'closed' => 'Fechado',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
