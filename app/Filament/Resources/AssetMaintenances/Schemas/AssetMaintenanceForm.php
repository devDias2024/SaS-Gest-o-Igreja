<?php

namespace App\Filament\Resources\AssetMaintenances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AssetMaintenanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Manutencao')
                    ->tabs([
                        Tab::make('Agendamento')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('asset_id')
                                            ->label('Bem')
                                            ->relationship('asset', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('type')
                                            ->label('Tipo')
                                            ->default('preventive')
                                            ->required()
                                            ->options([
                                                'preventive' => 'Preventiva',
                                                'corrective' => 'Corretiva',
                                            ]),
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('scheduled')
                                            ->required()
                                            ->options([
                                                'scheduled' => 'Agendada',
                                                'in_progress' => 'Em andamento',
                                                'completed' => 'Concluida',
                                                'canceled' => 'Cancelada',
                                            ]),
                                        DatePicker::make('scheduled_at')->label('Agendada para')->native(false),
                                        TextInput::make('provider')->label('Fornecedor/tecnico')->maxLength(255),
                                        Textarea::make('description')->label('Descricao')->rows(5)->columnSpanFull(),
                                    ]),
                            ]),
                        Tab::make('Execucao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        DatePicker::make('started_at')->label('Inicio')->native(false),
                                        DatePicker::make('completed_at')->label('Conclusao')->native(false),
                                        TextInput::make('cost')->label('Custo')->numeric()->prefix('R$')->default(0),
                                        DatePicker::make('next_maintenance_at')->label('Proxima manutencao')->native(false),
                                        Textarea::make('result')->label('Resultado')->rows(5)->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
