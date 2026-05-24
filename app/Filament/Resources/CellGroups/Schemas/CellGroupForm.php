<?php

namespace App\Filament\Resources\CellGroups\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CellGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Celula')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('status')->label('Status')->default('active')->required()->options([
                                            'active' => 'Ativa',
                                            'multiplying' => 'Em multiplicacao',
                                            'paused' => 'Pausada',
                                            'closed' => 'Encerrada',
                                        ]),
                                        Select::make('ministry_id')->label('Ministerio')->relationship('ministry', 'name')->searchable()->preload(),
                                        Select::make('leader_id')->label('Lider')->relationship('leader', 'full_name')->searchable()->preload(),
                                        Select::make('supervisor_id')->label('Supervisor')->relationship('supervisor', 'full_name')->searchable()->preload(),
                                        Select::make('meeting_day')->label('Dia')->options([
                                            'sunday' => 'Domingo',
                                            'monday' => 'Segunda',
                                            'tuesday' => 'Terca',
                                            'wednesday' => 'Quarta',
                                            'thursday' => 'Quinta',
                                            'friday' => 'Sexta',
                                            'saturday' => 'Sabado',
                                        ]),
                                        TimePicker::make('meeting_time')->label('Horario')->seconds(false),
                                        TextInput::make('capacity')->label('Capacidade')->numeric(),
                                        DatePicker::make('started_on')->label('Inicio')->native(false),
                                        TextInput::make('host_name')->label('Anfitriao')->maxLength(255),
                                    ]),
                            ]),
                        Tab::make('Localizacao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('address')->label('Endereco')->maxLength(255)->columnSpanFull(),
                                        TextInput::make('neighborhood')->label('Bairro')->maxLength(255),
                                        TextInput::make('city')->label('Cidade')->maxLength(255),
                                        TextInput::make('state')->label('UF')->maxLength(2),
                                        TextInput::make('latitude')->label('Latitude')->numeric(),
                                        TextInput::make('longitude')->label('Longitude')->numeric(),
                                    ]),
                            ]),
                        Tab::make('Descricao')
                            ->schema([
                                Textarea::make('description')->label('Descricao')->rows(6)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
