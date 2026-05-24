<?php

namespace App\Filament\Widgets;

use App\Models\ChurchEvent;
use App\Models\EventCheckIn;
use App\Models\EventRegistration;
use App\Models\OfflineCheckInBatch;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $upcomingEvents = ChurchEvent::query()
            ->where('starts_at', '>=', now())
            ->whereNot('status', 'canceled')
            ->count();

        $registrationsThisMonth = EventRegistration::query()
            ->whereHas('event', fn ($query) => $query
                ->whereMonth('starts_at', now()->month)
                ->whereYear('starts_at', now()->year))
            ->sum('quantity');

        $checkInsThisMonth = EventCheckIn::query()
            ->whereMonth('checked_in_at', now()->month)
            ->whereYear('checked_in_at', now()->year)
            ->count();

        $offlinePending = OfflineCheckInBatch::query()
            ->where('status', 'pending')
            ->count();

        return [
            Stat::make('Proximos eventos', (string) $upcomingEvents)
                ->description('Agenda futura')
                ->color('info'),
            Stat::make('Inscricoes no mes', (string) $registrationsThisMonth)
                ->description('Vagas reservadas')
                ->color('success'),
            Stat::make('Presencas no mes', (string) $checkInsThisMonth)
                ->description('Check-ins registrados')
                ->color('success'),
            Stat::make('Offline pendente', (string) $offlinePending)
                ->description('Lotes aguardando sincronizacao')
                ->color('warning'),
        ];
    }
}
