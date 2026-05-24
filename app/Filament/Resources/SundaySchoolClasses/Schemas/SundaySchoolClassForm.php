<?php

namespace App\Filament\Resources\SundaySchoolClasses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SundaySchoolClassForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Classe')->tabs([
                Tab::make('Cadastro')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('name')->label('Nome da classe')->required()->maxLength(255),
                        TextInput::make('course_name')->label('Curso')->maxLength(255),
                        Select::make('teacher_id')->label('Professor')->relationship('teacher', 'full_name')->searchable()->preload(),
                        Select::make('status')->label('Status')->default('active')->options(['active' => 'Ativa', 'completed' => 'Concluida', 'paused' => 'Pausada', 'archived' => 'Arquivada'])->required(),
                        TextInput::make('period_label')->label('Periodo')->placeholder('2026.1')->maxLength(255),
                        TextInput::make('schedule')->label('Horario')->maxLength(255),
                        TextInput::make('room')->label('Sala')->maxLength(255),
                        DatePicker::make('starts_on')->label('Inicio')->native(false),
                        DatePicker::make('ends_on')->label('Fim')->native(false),
                    ]),
                ]),
                Tab::make('Aprovacao')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('minimum_attendance_percent')->label('Frequencia minima')->numeric()->default(75)->suffix('%')->required(),
                        TextInput::make('minimum_grade')->label('Nota minima')->numeric()->step('0.01'),
                        Textarea::make('description')->label('Descricao')->rows(5)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
