<?php

namespace App\Filament\Resources\CellMemberships\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CellMembershipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cellGroup.name')->label('Celula')->searchable()->sortable(),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->sortable(),
                TextColumn::make('role')->label('Funcao')->badge(),
                TextColumn::make('joined_on')->label('Entrada')->date('d/m/Y')->sortable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload(),
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativo',
                    'inactive' => 'Inativo',
                    'transferred' => 'Transferido',
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
