<?php

namespace App\Filament\Resources\PublicContacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PublicContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Recebido')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('email')->label('E-mail')->searchable(),
                TextColumn::make('phone')->label('Telefone')->searchable(),
                TextColumn::make('subject')->label('Assunto')->searchable()->limit(35),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'new' => 'Novo',
                    'in_progress' => 'Em atendimento',
                    'responded' => 'Respondido',
                    'closed' => 'Fechado',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
