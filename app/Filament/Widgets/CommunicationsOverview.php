<?php

namespace App\Filament\Widgets;

use App\Models\CommunicationAutomation;
use App\Models\CommunicationCampaign;
use App\Models\CommunicationInboxThread;
use App\Models\CommunicationMessage;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommunicationsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $scheduledCampaigns = CommunicationCampaign::query()->where('status', 'scheduled')->count();
        $sentThisMonth = CommunicationMessage::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['sent', 'delivered', 'opened', 'clicked'])
            ->count();
        $openedThisMonth = CommunicationMessage::query()
            ->whereMonth('opened_at', now()->month)
            ->whereYear('opened_at', now()->year)
            ->count();
        $openThreads = CommunicationInboxThread::query()->where('status', 'open')->count();
        $activeAutomations = CommunicationAutomation::query()->where('status', 'active')->count();

        return [
            Stat::make('Campanhas agendadas', (string) $scheduledCampaigns)->color('warning'),
            Stat::make('Mensagens no mes', (string) $sentThisMonth)->color('success'),
            Stat::make('Aberturas no mes', (string) $openedThisMonth)->color('info'),
            Stat::make('Conversas abertas', (string) $openThreads)->color('warning'),
            Stat::make('Automacoes ativas', (string) $activeAutomations)->color('success'),
        ];
    }
}
