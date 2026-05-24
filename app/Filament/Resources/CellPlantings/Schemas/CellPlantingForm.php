<?php

namespace App\Filament\Resources\CellPlantings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CellPlantingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Plantacao de celula')
                    ->tabs([
                        Tab::make('Planejamento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        TextInput::make('name')->label('Nome/projeto')->required()->maxLength(255)->columnSpan(['md' => 2]),
                                        Select::make('status')->label('Status')->default('planning')->required()->options([
                                            'planning' => 'Planejamento',
                                            'training' => 'Treinando lideranca',
                                            'launched' => 'Plantada',
                                            'paused' => 'Pausada',
                                            'canceled' => 'Cancelada',
                                        ]),
                                        Select::make('parent_cell_group_id')->label('Celula mae')->relationship('parentCellGroup', 'name')->searchable()->preload(),
                                        Select::make('new_cell_group_id')->label('Nova celula')->relationship('newCellGroup', 'name')->searchable()->preload(),
                                        Select::make('leader_id')->label('Lider previsto')->relationship('leader', 'full_name')->searchable()->preload(),
                                        Select::make('supervisor_id')->label('Supervisor')->relationship('supervisor', 'full_name')->searchable()->preload(),
                                        TextInput::make('initial_members_goal')->label('Meta inicial de membros')->numeric()->default(8),
                                    ]),
                            ]),
                        Tab::make('Territorio')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        TextInput::make('target_neighborhood')->label('Bairro alvo')->maxLength(255),
                                        TextInput::make('target_city')->label('Cidade alvo')->maxLength(255),
                                        DatePicker::make('planned_start_on')->label('Inicio previsto')->native(false),
                                        DatePicker::make('launched_on')->label('Plantada em')->native(false),
                                    ]),
                            ]),
                        Tab::make('Estrategia')
                            ->schema([
                                Textarea::make('strategy')->label('Estrategia')->rows(5)->columnSpanFull(),
                                Textarea::make('notes')->label('Observacoes')->rows(4)->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
