<?php

namespace App\Filament\Resources\SundaySchoolGrades\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SundaySchoolGradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Grid::make(['default' => 1, 'md' => 2])->schema([
            Select::make('sunday_school_enrollment_id')->label('Matricula')->relationship('enrollment.member', 'full_name')->searchable()->preload()->required(),
            TextInput::make('lesson_title')->label('Licao/atividade')->required()->maxLength(255),
            DatePicker::make('graded_on')->label('Data')->native(false),
            Select::make('grade_type')->label('Tipo')->default('numeric')->required()->options(['numeric' => 'Numero', 'concept' => 'Conceito']),
            TextInput::make('numeric_grade')->label('Nota')->numeric()->step('0.01'),
            Select::make('concept_grade')->label('Conceito')->options(['A' => 'A - Excelente', 'B' => 'B - Bom', 'C' => 'C - Regular', 'D' => 'D - Insuficiente']),
            TextInput::make('weight')->label('Peso')->numeric()->default(1)->step('0.01'),
            Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
        ])->columnSpanFull()]);
    }
}
