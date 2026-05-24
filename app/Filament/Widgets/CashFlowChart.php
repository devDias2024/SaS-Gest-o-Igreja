<?php

namespace App\Filament\Widgets;

use App\Models\FinancialTransaction;
use App\Services\PanelPermissionService;
use Filament\Widgets\ChartWidget;

class CashFlowChart extends ChartWidget
{
    protected static ?int $sort = 4;

    protected ?string $heading = 'Fluxo de caixa mensal';

    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return app(PanelPermissionService::class)->allows(auth()->user(), 'Financeiro', 'view');
    }

    protected function getData(): array
    {
        $labels = collect(range(5, 0))
            ->map(fn (int $monthsAgo) => now()->subMonths($monthsAgo))
            ->values();

        $income = $labels->map(fn ($date): float => (float) FinancialTransaction::query()
            ->whereIn('type', ['tithe', 'offering', 'income'])
            ->whereMonth('transaction_date', $date->month)
            ->whereYear('transaction_date', $date->year)
            ->sum('amount'));

        $expenses = $labels->map(fn ($date): float => (float) FinancialTransaction::query()
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $date->month)
            ->whereYear('transaction_date', $date->year)
            ->sum('amount'));

        return [
            'datasets' => [
                [
                    'label' => 'Entradas',
                    'data' => $income->all(),
                    'borderColor' => '#16a34a',
                    'backgroundColor' => '#16a34a',
                ],
                [
                    'label' => 'Saidas',
                    'data' => $expenses->all(),
                    'borderColor' => '#dc2626',
                    'backgroundColor' => '#dc2626',
                ],
            ],
            'labels' => $labels->map(fn ($date): string => $date->format('m/Y'))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
