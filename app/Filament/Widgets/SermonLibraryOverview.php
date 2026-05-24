<?php

namespace App\Filament\Widgets;

use App\Models\Sermon;
use App\Models\SermonMedia;
use App\Models\SermonShareLink;
use App\Models\SermonView;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SermonLibraryOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $published = Sermon::query()->where('status', 'published')->count();
        $viewsThisMonth = SermonView::query()
            ->whereMonth('viewed_at', now()->month)
            ->whereYear('viewed_at', now()->year)
            ->count();
        $uploads = SermonMedia::query()->where('source', 'upload')->count();
        $liveEmbeds = SermonMedia::query()->where('media_type', 'live')->count();
        $activeLinks = SermonShareLink::query()
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->count();

        return [
            Stat::make('Pregacoes publicadas', (string) $published)->color('success'),
            Stat::make('Views no mes', (string) $viewsThisMonth)->color('info'),
            Stat::make('Uploads', (string) $uploads)->color('warning'),
            Stat::make('Lives/embeds', (string) $liveEmbeds)->color('info'),
            Stat::make('Links ativos', (string) $activeLinks)->color('success'),
        ];
    }
}
