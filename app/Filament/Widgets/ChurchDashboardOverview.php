<?php

namespace App\Filament\Widgets;

use App\Models\CellGroup;
use App\Models\ChurchEvent;
use App\Models\FinancialTransaction;
use App\Models\Member;
use App\Models\PublicContact;
use App\Models\VisitorRegistration;
use App\Services\PanelPermissionService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class ChurchDashboardOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        $permissions = app(PanelPermissionService::class);

        return collect([
            'Gestao de Membros',
            'Eventos & Cultos',
            'Ministerios & Celulas',
            'Site Publico',
            'Financeiro',
            'Aconselhamento Pastoral',
        ])->contains(fn (string $module): bool => $permissions->allows(auth()->user(), $module, 'view'));
    }

    protected function getStats(): array
    {
        $permissions = app(PanelPermissionService::class);
        $user = auth()->user();
        $stats = [];

        if ($permissions->allows($user, 'Gestao de Membros', 'view')) {
            $stats[] = Stat::make('Membros', (string) Member::query()->count())
                ->description('Cadastrados')
                ->color('success');
            $stats[] = Stat::make('Batizados', (string) Member::query()->whereNotNull('baptism_date')->count())
                ->description('Com data de batismo')
                ->color('success');
        }

        if ($permissions->allows($user, 'Site Publico', 'view')) {
            $stats[] = Stat::make('Visitantes', (string) VisitorRegistration::query()->count())
                ->description('Registrados')
                ->color('info');
        }

        if ($permissions->allows($user, 'Ministerios & Celulas', 'view')) {
            $stats[] = Stat::make('Celulas', (string) CellGroup::query()->where('status', 'active')->count())
                ->description('Ativas')
                ->color('warning');
        }

        if ($permissions->allows($user, 'Eventos & Cultos', 'view')) {
            $stats[] = Stat::make('Proximos eventos', (string) ChurchEvent::query()
                ->where('starts_at', '>=', now())
                ->whereNot('status', 'canceled')
                ->count())
                ->description('Na agenda')
                ->color('primary');
        }

        if ($permissions->allows($user, 'Financeiro', 'view')) {
            $monthlyTransactions = FinancialTransaction::query()
                ->where('status', 'confirmed')
                ->whereMonth('transaction_date', now()->month)
                ->whereYear('transaction_date', now()->year);
            $income = (clone $monthlyTransactions)->whereIn('type', ['tithe', 'offering', 'income'])->sum('amount');
            $expenses = (clone $monthlyTransactions)->where('type', 'expense')->sum('amount');

            $stats[] = Stat::make('Entradas do mes', Number::currency((float) $income, 'BRL', 'pt_BR'))
                ->color('success');
            $stats[] = Stat::make('Saidas do mes', Number::currency((float) $expenses, 'BRL', 'pt_BR'))
                ->color('danger');
        }

        if ($permissions->allows($user, 'Aconselhamento Pastoral', 'view')) {
            $stats[] = Stat::make('Pedidos de oracao', (string) PublicContact::query()
                ->whereIn('status', ['new', 'in_progress'])
                ->where(fn ($query) => $query
                    ->where('source', 'prayer')
                    ->orWhere('subject', 'Pedido de oracao pelo site'))
                ->count())
                ->description('Para acompanhar')
                ->color('warning');
        }

        return $stats;
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
