<?php

namespace App\Filament\Resources\AssetLoans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class AssetLoanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Emprestimo')
                    ->tabs([
                        Tab::make('Retirada')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('asset_id')
                                            ->label('Equipamento')
                                            ->relationship('asset', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        Select::make('member_id')
                                            ->label('Membro')
                                            ->relationship('member', 'full_name')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('borrower_name')
                                            ->label('Retirado por')
                                            ->maxLength(255),
                                        TextInput::make('borrower_contact')
                                            ->label('Contato')
                                            ->maxLength(255),
                                        DatePicker::make('loaned_at')
                                            ->label('Data de emprestimo')
                                            ->default(now())
                                            ->required()
                                            ->native(false),
                                        DatePicker::make('due_at')
                                            ->label('Data de devolucao prevista')
                                            ->native(false),
                                        Select::make('condition_out')
                                            ->label('Condicao na retirada')
                                            ->options([
                                                'new' => 'Novo',
                                                'good' => 'Bom',
                                                'fair' => 'Regular',
                                                'damaged' => 'Danificado',
                                            ]),
                                    ]),
                            ]),
                        Tab::make('Devolucao')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])
                                    ->schema([
                                        Select::make('status')
                                            ->label('Status')
                                            ->default('open')
                                            ->required()
                                            ->options([
                                                'open' => 'Em aberto',
                                                'returned' => 'Devolvido',
                                                'late' => 'Atrasado',
                                                'lost' => 'Extraviado',
                                            ]),
                                        DatePicker::make('returned_at')
                                            ->label('Devolvido em')
                                            ->native(false),
                                        Select::make('condition_in')
                                            ->label('Condicao na devolucao')
                                            ->options([
                                                'new' => 'Novo',
                                                'good' => 'Bom',
                                                'fair' => 'Regular',
                                                'damaged' => 'Danificado',
                                            ]),
                                        Textarea::make('notes')
                                            ->label('Observacoes')
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
