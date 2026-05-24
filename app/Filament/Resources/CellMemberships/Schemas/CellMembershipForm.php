<?php

namespace App\Filament\Resources\CellMemberships\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CellMembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Membro da celula')
                    ->tabs([
                        Tab::make('Vinculo')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('cell_group_id')->label('Celula')->relationship('cellGroup', 'name')->searchable()->preload()->required(),
                                        Select::make('member_id')->label('Membro')->relationship('member', 'full_name')->searchable()->preload()->required(),
                                        Select::make('role')->label('Funcao')->default('member')->required()->options([
                                            'member' => 'Membro',
                                            'leader' => 'Lider',
                                            'host' => 'Anfitriao',
                                            'trainee' => 'Lider em treinamento',
                                        ]),
                                        Select::make('status')->label('Status')->default('active')->required()->options([
                                            'active' => 'Ativo',
                                            'inactive' => 'Inativo',
                                            'transferred' => 'Transferido',
                                        ]),
                                        DatePicker::make('joined_on')->label('Entrada')->native(false),
                                        DatePicker::make('left_on')->label('Saida')->native(false),
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
