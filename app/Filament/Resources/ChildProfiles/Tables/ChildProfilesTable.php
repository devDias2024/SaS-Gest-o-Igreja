<?php

namespace App\Filament\Resources\ChildProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChildProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('Crianca')->searchable()->sortable(),
                TextColumn::make('birth_date')->label('Nascimento')->date('d/m/Y')->sortable(),
                TextColumn::make('ageGroup.name')->label('Sala')->badge()->sortable(),
                TextColumn::make('guardians.name')->label('Responsaveis')->listWithLineBreaks()->limitList(2),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('created_at')->label('Cadastro')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativo',
                    'inactive' => 'Inativo',
                ]),
                SelectFilter::make('child_age_group_id')->label('Sala')->relationship('ageGroup', 'name')->searchable()->preload(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
