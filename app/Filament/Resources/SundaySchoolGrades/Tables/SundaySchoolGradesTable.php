<?php

namespace App\Filament\Resources\SundaySchoolGrades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SundaySchoolGradesTable
{
    public static function configure(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('graded_on')->label('Data')->date('d/m/Y')->sortable(),
            TextColumn::make('enrollment.member.full_name')->label('Aluno')->searchable(),
            TextColumn::make('enrollment.class.name')->label('Classe')->searchable(),
            TextColumn::make('lesson_title')->label('Licao')->searchable(),
            TextColumn::make('numeric_grade')->label('Nota')->sortable(),
            TextColumn::make('concept_grade')->label('Conceito')->badge(),
            TextColumn::make('weight')->label('Peso'),
        ])->filters([
            SelectFilter::make('grade_type')->label('Tipo')->options(['numeric' => 'Numero', 'concept' => 'Conceito']),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])->defaultSort('graded_on', 'desc');
    }
}
