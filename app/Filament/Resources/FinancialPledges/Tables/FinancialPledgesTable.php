<?php

namespace App\Filament\Resources\FinancialPledges\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FinancialPledgesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.full_name')->label('Membro')->searchable()->sortable(),
                TextColumn::make('monthly_amount')->label('Valor mensal')->money('BRL')->sortable(),
                TextColumn::make('paid_this_month')->label('Pago no mes')->state(fn ($record): float => $record->amountPaidForMonth())->money('BRL'),
                IconColumn::make('fulfilled')->label('Cumpriu')->boolean()->state(fn ($record): bool => $record->isFulfilledForCurrentMonth()),
                TextColumn::make('due_day')->label('Vencimento')->formatStateUsing(fn ($state): string => "Dia {$state}"),
                TextColumn::make('fund.name')->label('Fundo')->toggleable(),
                TextColumn::make('status')->label('Status')->badge(),
            ])
            ->filters([
                SelectFilter::make('status')->label('Status')->options([
                    'active' => 'Ativa',
                    'paused' => 'Pausada',
                    'completed' => 'Concluida',
                    'canceled' => 'Cancelada',
                ]),
                Filter::make('late_this_month')
                    ->label('Em aberto no mes')
                    ->query(fn (Builder $query): Builder => $query->where('status', 'active')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
