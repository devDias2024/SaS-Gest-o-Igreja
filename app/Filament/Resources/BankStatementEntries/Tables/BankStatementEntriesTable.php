<?php

namespace App\Filament\Resources\BankStatementEntries\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BankStatementEntriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('posted_at')->label('Data')->date('d/m/Y')->sortable(),
                TextColumn::make('description')->label('Descricao')->searchable(),
                TextColumn::make('amount')->label('Valor')->money('BRL')->sortable(),
                TextColumn::make('reference')->label('Referencia')->searchable()->toggleable(),
                TextColumn::make('status')->label('Status')->badge(),
                IconColumn::make('financial_transaction_id')->label('Vinculado')->boolean()->state(fn ($record): bool => filled($record->financial_transaction_id)),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'matched' => 'Conciliado',
                    'ignored' => 'Ignorado',
                ]),
            ])
            ->recordActions([
                Action::make('reconcile')
                    ->label('Conciliar')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Select::make('financial_transaction_id')
                            ->label('Lancamento')
                            ->relationship('transaction', 'description')
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data, $record): void {
                        $record->update([
                            'financial_transaction_id' => $data['financial_transaction_id'],
                            'status' => 'matched',
                            'reconciled_at' => now(),
                        ]);

                        $record->transaction?->update(['reconciled_at' => now()]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
