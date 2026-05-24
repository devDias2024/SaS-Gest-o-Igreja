<?php

namespace App\Filament\Resources\ChildPickupAuthorizations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChildPickupAuthorizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('child.full_name')->label('Crianca')->searchable()->sortable(),
                TextColumn::make('authorized_name')->label('Autorizado')->searchable()->sortable(),
                TextColumn::make('document_number')->label('Documento')->searchable(),
                TextColumn::make('phone')->label('Telefone')->searchable(),
                TextColumn::make('valid_until')->label('Valida ate')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'used' => 'Usada',
                    'expired' => 'Expirada',
                    'revoked' => 'Revogada',
                ]),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
