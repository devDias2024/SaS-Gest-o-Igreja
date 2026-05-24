<?php

namespace App\Filament\Resources\MinistryGoals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class MinistryGoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Meta')
                    ->tabs([
                        Tab::make('Dados')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('title')->label('Titulo')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('metric')->label('Metrica')->default('members')->required()->options([
                                            'members' => 'Membros',
                                            'attendance' => 'Frequencia',
                                            'visitors' => 'Visitantes',
                                            'new_cells' => 'Novas celulas',
                                            'leaders' => 'Novos lideres',
                                        ]),
                                        Select::make('ministry_id')->label('Ministerio')->relationship('ministry', 'name')->searchable()->preload(),
                                        Select::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload(),
                                        Select::make('status')->label('Status')->default('active')->required()->options([
                                            'active' => 'Ativa',
                                            'reached' => 'Alcancada',
                                            'paused' => 'Pausada',
                                            'canceled' => 'Cancelada',
                                        ]),
                                        TextInput::make('target_value')->label('Meta')->numeric()->required(),
                                        TextInput::make('current_value')->label('Atual')->numeric()->default(0),
                                        DatePicker::make('starts_on')->label('Inicio')->native(false),
                                        DatePicker::make('ends_on')->label('Fim')->native(false),
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
