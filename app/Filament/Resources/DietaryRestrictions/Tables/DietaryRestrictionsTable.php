<?php

namespace App\Filament\Resources\DietaryRestrictions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class DietaryRestrictionsTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('member.full_name')->label('Membro')->searchable()->sortable(),
            TextColumn::make('type')->label('Tipo')->badge()->sortable(),
            TextColumn::make('severity')->label('Gravidade')->badge()->sortable(),
            TextColumn::make('description')->label('Descricao')->searchable()->limit(50),
            IconColumn::make('is_active')->label('Ativa')->boolean(),
        ])->filters([
            SelectFilter::make('type')->label('Tipo')->options([
                'allergy' => 'Alergia',
                'diabetes' => 'Diabetes',
                'hypertension' => 'Hipertensao',
                'intolerance' => 'Intolerancia',
                'diet' => 'Dieta especifica',
                'other' => 'Outro',
            ]),
            SelectFilter::make('severity')->label('Gravidade')->options([
                'attention' => 'Atencao',
                'moderate' => 'Moderada',
                'severe' => 'Grave',
                'critical' => 'Critica',
            ]),
            TernaryFilter::make('is_active')->label('Ativa'),
        ])->recordActions([
            EditAction::make(),
        ])->toolbarActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
        ]);
    }
}
