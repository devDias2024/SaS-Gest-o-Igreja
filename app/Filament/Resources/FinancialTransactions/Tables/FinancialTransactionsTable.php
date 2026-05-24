<?php

namespace App\Filament\Resources\FinancialTransactions\Tables;

use App\Filament\Exports\FinancialTransactionExporter;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FinancialTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('transaction_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'tithe' => 'Dizimo',
                        'offering' => 'Oferta',
                        'income' => 'Receita',
                        'expense' => 'Despesa',
                        default => 'Outro',
                    }),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('member.full_name')
                    ->label('Membro')
                    ->searchable()
                    ->placeholder('Anonimo'),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('fund.name')
                    ->label('Fundo')
                    ->toggleable(),
                TextColumn::make('payment_method')
                    ->label('Pagamento')
                    ->toggleable(),
                IconColumn::make('receipt_sent_at')
                    ->label('Recibo')
                    ->boolean()
                    ->state(fn ($record): bool => filled($record->receipt_sent_at)),
                IconColumn::make('reconciled_at')
                    ->label('Conciliado')
                    ->boolean()
                    ->state(fn ($record): bool => filled($record->reconciled_at)),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'tithe' => 'Dizimo',
                        'offering' => 'Oferta',
                        'income' => 'Receita',
                        'expense' => 'Despesa',
                    ]),
                SelectFilter::make('financial_category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('fund_id')
                    ->label('Fundo')
                    ->relationship('fund', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('this_month')
                    ->label('Mes atual')
                    ->query(fn (Builder $query): Builder => $query
                        ->whereMonth('transaction_date', now()->month)
                        ->whereYear('transaction_date', now()->year)),
                Filter::make('not_reconciled')
                    ->label('Nao conciliados')
                    ->query(fn (Builder $query): Builder => $query->whereNull('reconciled_at')),
            ])
            ->recordActions([
                Action::make('markReceiptSent')
                    ->label('Recibo enviado')
                    ->icon('heroicon-o-envelope')
                    ->visible(fn ($record): bool => blank($record->receipt_sent_at))
                    ->action(fn ($record) => $record->update(['receipt_sent_at' => now()])),
                Action::make('markReconciled')
                    ->label('Conciliar')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn ($record): bool => blank($record->reconciled_at))
                    ->action(fn ($record) => $record->update(['reconciled_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(FinancialTransactionExporter::class),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
