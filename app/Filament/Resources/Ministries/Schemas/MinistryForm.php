<?php

namespace App\Filament\Resources\Ministries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MinistryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Ministerio')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('type')->label('Tipo')->default('ministry')->required()->options([
                                            'ministry' => 'Ministerio',
                                            'cell_network' => 'Rede de celulas',
                                            'department' => 'Departamento',
                                        ]),
                                        Select::make('leader_id')->label('Lider')->relationship('leader', 'full_name')->searchable()->preload(),
                                        Select::make('supervisor_id')->label('Supervisor')->relationship('supervisor', 'full_name')->searchable()->preload(),
                                        Select::make('status')->label('Status')->default('active')->required()->options([
                                            'active' => 'Ativo',
                                            'paused' => 'Pausado',
                                            'closed' => 'Encerrado',
                                        ]),
                                        DatePicker::make('started_on')->label('Inicio')->native(false),
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
