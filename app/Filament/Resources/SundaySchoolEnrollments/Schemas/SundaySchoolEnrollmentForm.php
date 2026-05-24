<?php

namespace App\Filament\Resources\SundaySchoolEnrollments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SundaySchoolEnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Matricula')->tabs([
                Tab::make('Aluno')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        Select::make('sunday_school_class_id')->label('Classe')->relationship('class', 'name')->searchable()->preload()->required(),
                        Select::make('member_id')->label('Aluno/membro')->relationship('member', 'full_name')->searchable()->preload()->required(),
                        DatePicker::make('enrolled_on')->label('Inicio do periodo')->native(false),
                        DatePicker::make('completed_on')->label('Fim/conclusao')->native(false),
                        Select::make('status')->label('Status')->default('active')->required()->options([
                            'active' => 'Ativa',
                            'completed' => 'Concluida',
                            'approved' => 'Aprovado',
                            'failed' => 'Reprovado',
                            'dropped' => 'Desistente',
                        ]),
                    ]),
                ]),
                Tab::make('Resultado')->schema([
                    Grid::make(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('attendance_percent')->label('Frequencia')->numeric()->suffix('%')->disabled(),
                        TextInput::make('final_grade')->label('Media final')->numeric()->disabled(),
                        Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                    ]),
                ]),
            ])->persistTabInQueryString()->columnSpanFull(),
        ]);
    }
}
