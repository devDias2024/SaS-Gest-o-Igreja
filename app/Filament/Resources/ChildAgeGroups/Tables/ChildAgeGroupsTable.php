<?php

namespace App\Filament\Resources\ChildAgeGroups\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ChildAgeGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Faixa')->searchable()->sortable(),
                TextColumn::make('location')->label('Sala')->searchable(),
                TextColumn::make('min_age_months')->label('Min. meses')->sortable(),
                TextColumn::make('max_age_months')->label('Max. meses')->sortable(),
                TextColumn::make('capacity')->label('Capacidade')->sortable(),
                IconColumn::make('is_active')->label('Ativa')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
