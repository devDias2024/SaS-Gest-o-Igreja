<?php

namespace App\Filament\Widgets;

use App\Models\FinancialPledge;
use App\Models\FinancialTransaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class FinancialOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $monthIncome = FinancialTransaction::query()
            ->whereIn('type', ['tithe', 'offering', 'income'])
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $monthExpenses = FinancialTransaction::query()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('amount');

        $unreconciled = FinancialTransaction::query()
            ->whereNull('reconciled_at')
            ->where('status', 'confirmed')
            ->count();

        $openPledges = FinancialPledge::query()
            ->where('status', 'active')
            ->get()
            ->filter(fn (FinancialPledge $pledge): bool => ! $pledge->isFulfilledForCurrentMonth())
            ->count();

        return [
            Stat::make('Entradas do mes', Number::currency((float) $monthIncome, 'BRL', 'pt_BR'))
                ->description('Dizimos, ofertas e receitas')
                ->color('success'),
            Stat::make('Saidas do mes', Number::currency((float) $monthExpenses, 'BRL', 'pt_BR'))
                ->description('Despesas confirmadas')
                ->color('danger'),
            Stat::make('Saldo do mes', Number::currency((float) ($monthIncome - $monthExpenses), 'BRL', 'pt_BR'))
                ->description('Entradas menos saidas')
                ->color($monthIncome >= $monthExpenses ? 'success' : 'danger'),
            Stat::make('A conciliar', (string) $unreconciled)
                ->description('Lancamentos confirmados')
                ->color('warning'),
            Stat::make('Promessas em aberto', (string) $openPledges)
                ->description('Mes atual')
                ->color('info'),
        ];
    }
}
