<?php

namespace App\Filament\Resources\PanelUsers\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PanelUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('email')->label('E-mail')->searchable(),
                TextColumn::make('panelRole.name')->label('Perfil')->badge()->placeholder('Sem perfil'),
                IconColumn::make('is_super_admin')->label('Admin total')->boolean(),
                IconColumn::make('can_access_panel')->label('Acesso')->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
