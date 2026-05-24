<?php

namespace App\Filament\Resources\OnlineDonations\Tables;

use App\Models\FinancialTransaction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OnlineDonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Data')->dateTime('d/m/Y H:i')->sortable(),
                TextColumn::make('donor_name')->label('Doador')->searchable()->placeholder('Anonimo'),
                TextColumn::make('member.full_name')->label('Membro')->searchable()->toggleable(),
                TextColumn::make('amount')->label('Valor')->money('BRL')->sortable(),
                TextColumn::make('fund.name')->label('Fundo')->toggleable(),
                TextColumn::make('payment_gateway')->label('Gateway')->toggleable(),
                TextColumn::make('status')->label('Status')->badge(),
                IconColumn::make('receipt_sent_at')->label('Recibo')->boolean()->state(fn ($record): bool => filled($record->receipt_sent_at)),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'pending' => 'Pendente',
                    'paid' => 'Paga',
                    'failed' => 'Falhou',
                    'refunded' => 'Estornada',
                ]),
            ])
            ->recordActions([
                Action::make('createTransaction')
                    ->label('Gerar lancamento')
                    ->icon('heroicon-o-banknotes')
                    ->visible(fn ($record): bool => $record->status === 'paid' && blank($record->financial_transaction_id))
                    ->action(function ($record): void {
                        $transaction = FinancialTransaction::query()->create([
                            'member_id' => $record->member_id,
                            'fund_id' => $record->fund_id,
                            'type' => 'offering',
                            'transaction_date' => ($record->paid_at ?? now())->toDateString(),
                            'amount' => $record->amount,
                            'payment_method' => $record->payment_method,
                            'document_number' => $record->gateway_reference,
                            'source' => 'online',
                            'is_anonymous' => $record->is_anonymous,
                            'status' => 'confirmed',
                            'description' => 'Doacao online',
                            'receipt_sent_at' => $record->receipt_sent_at,
                        ]);

                        $record->update(['financial_transaction_id' => $transaction->id]);
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
