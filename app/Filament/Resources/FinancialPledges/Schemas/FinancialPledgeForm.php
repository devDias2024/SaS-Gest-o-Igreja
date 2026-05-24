<?php

namespace App\Filament\Resources\FinancialPledges\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class FinancialPledgeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Promessa mensal')
                    ->tabs([
                        Tab::make('Compromisso')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        Select::make('member_id')
                                            ->label('Membro')
                                            ->relationship('member', 'full_name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('type')
                                            ->label('Tipo')
                                            ->default('tithe')
                                            ->required()
                                            ->options([
                                                'tithe' => 'Dizimo fidelidade',
                                                'pledge' => 'Promessa',
                                            ]),
                                        TextInput::make('monthly_amount')
                                            ->label('Valor mensal')
                                            ->numeric()
                                            ->prefix('R$')
                                            ->required(),
                                        TextInput::make('due_day')
                                            ->label('Dia de vencimento')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(31)
                                            ->default(10)
                                            ->required(),
                                        Select::make('fund_id')
                                            ->label('Fundo')
                                            ->relationship('fund', 'name')
                                            ->searchable()
                                            ->preload(),
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('active')
                                            ->required()
                                            ->options([
                                                'active' => 'Ativa',
                                                'paused' => 'Pausada',
                                                'completed' => 'Concluida',
                                                'canceled' => 'Cancelada',
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Periodo e avisos')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 3])
                                    ->schema([
                                        DatePicker::make('starts_on')
                                            ->label('Inicio')
                                            ->default(now())
                                            ->required()
                                            ->native(false),
                                        DatePicker::make('ends_on')
                                            ->label('Fim')
                                            ->native(false),
                                        DatePicker::make('last_reminder_sent_at')
                                            ->label('Ultimo aviso')
                                            ->native(false),
                                        Textarea::make('notes')
                                            ->label('Observacoes')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
