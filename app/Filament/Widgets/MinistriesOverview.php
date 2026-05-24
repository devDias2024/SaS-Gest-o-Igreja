<?php

namespace App\Filament\Widgets;

use App\Models\CellAttendance;
use App\Models\CellGroup;
use App\Models\CellPlanting;
use App\Models\Ministry;
use App\Models\PastoralVisit;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MinistriesOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $activeCells = CellGroup::query()->where('status', 'active')->count();
        $ministries = Ministry::query()->where('status', 'active')->count();
        $attendanceThisMonth = CellAttendance::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'present')
            ->count();
        $pendingVisits = PastoralVisit::query()->where('status', 'scheduled')->count();
        $plantings = CellPlanting::query()->whereIn('status', ['planning', 'training'])->count();

        return [
            Stat::make('Ministerios ativos', (string) $ministries)->color('info'),
            Stat::make('Celulas ativas', (string) $activeCells)->color('success'),
            Stat::make('Frequencia no mes', (string) $attendanceThisMonth)->color('success'),
            Stat::make('Visitas pendentes', (string) $pendingVisits)->color('warning'),
            Stat::make('Plantacoes em andamento', (string) $plantings)->color('info'),
        ];
    }
}
