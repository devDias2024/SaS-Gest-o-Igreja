<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetLoan;
use App\Models\AssetMaintenance;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class AssetInventoryOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalAssets = Asset::query()->whereIn('asset_type', ['asset', 'both'])->count();
        $totalValue = Asset::query()->sum('purchase_value');
        $currentValue = Asset::query()->get()->sum(fn (Asset $asset): float => $asset->current_value);
        $lowStock = Asset::query()->whereColumn('quantity_on_hand', '<=', 'minimum_quantity')->count();
        $loansDue = AssetLoan::query()
            ->whereNull('returned_at')
            ->whereDate('due_at', '<=', now()->addDays(7))
            ->count();
        $maintenanceDue = AssetMaintenance::query()
            ->whereNull('completed_at')
            ->whereDate('scheduled_at', '<=', now()->addDays(30))
            ->count();
        $warrantyDue = Asset::query()
            ->whereBetween('warranty_expires_at', [now(), now()->addDays(30)])
            ->count();

        return [
            Stat::make('Bens cadastrados', (string) $totalAssets)->color('info'),
            Stat::make('Valor de compra', Number::currency($totalValue, 'BRL', 'pt_BR'))->color('success'),
            Stat::make('Valor depreciado', Number::currency($currentValue, 'BRL', 'pt_BR'))->color('success'),
            Stat::make('Estoque baixo', (string) $lowStock)->color($lowStock > 0 ? 'danger' : 'success'),
            Stat::make('Devolucoes proximas', (string) $loansDue)->color($loansDue > 0 ? 'warning' : 'success'),
            Stat::make('Manutencoes proximas', (string) $maintenanceDue)->color($maintenanceDue > 0 ? 'warning' : 'success'),
            Stat::make('Garantias vencendo', (string) $warrantyDue)->color($warrantyDue > 0 ? 'warning' : 'success'),
        ];
    }
}
