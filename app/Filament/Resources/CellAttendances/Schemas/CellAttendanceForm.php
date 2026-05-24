<?php

namespace App\Filament\Resources\CellAttendances\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CellAttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Frequencia')
                    ->tabs([
                        Tab::make('Presenca')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('cell_meeting_id')->label('Reuniao')->relationship('meeting', 'theme')->searchable()->preload()->required(),
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload(),
                                        TextInput::make('guest_name')->label('Visitante')->maxLength(255),
                                        Select::make('status')->label('Status')->default('present')->required()->options([
                                            'present' => 'Presente',
                                            'absent' => 'Ausente',
                                            'justified' => 'Justificado',
                                        ]),
                                        DateTimePicker::make('checked_in_at')->label('Registrado em')->default(now())->native(false),
                                    ]),
                            ]),
                        Tab::make('Observacoes')
                            ->schema([
                                Textarea::make('notes')->label('Observacoes')->rows(5)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
