<?php

namespace App\Filament\Resources\SundaySchoolAttendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SundaySchoolAttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([Grid::make(['default' => 1, 'md' => 2])->schema([
            Select::make('sunday_school_enrollment_id')->label('Matricula')->relationship('enrollment.member', 'full_name')->searchable()->preload()->required(),
            DatePicker::make('lesson_date')->label('Data da aula')->native(false)->required(),
            TextInput::make('lesson_title')->label('Licao')->maxLength(255),
            Select::make('status')->label('Status')->default('present')->required()->options(['present' => 'Presente', 'absent' => 'Ausente', 'justified' => 'Justificada']),
            Textarea::make('notes')->label('Observacoes')->rows(3)->columnSpanFull(),
        ])->columnSpanFull()]);
    }
}
