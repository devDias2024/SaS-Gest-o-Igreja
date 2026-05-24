<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ChurchEvents\ChurchEventResource;
use App\Models\ChurchEvent;
use App\Services\PanelPermissionService;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Validator;

class ChurchCalendar extends Widget
{
    protected static ?int $sort = 5;

    protected string $view = 'filament.widgets.church-calendar';

    protected int|string|array $columnSpan = 'full';

    public string $displayMonth;

    public static function canView(): bool
    {
        return app(PanelPermissionService::class)->allows(auth()->user(), 'Eventos & Cultos', 'view');
    }

    public function mount(): void
    {
        $this->displayMonth = now()->format('Y-m');
    }

    public function previousMonth(): void
    {
        $this->displayMonth = CarbonImmutable::createFromFormat('!Y-m', $this->displayMonth)
            ->subMonth()
            ->format('Y-m');
    }

    public function nextMonth(): void
    {
        $this->displayMonth = CarbonImmutable::createFromFormat('!Y-m', $this->displayMonth)
            ->addMonth()
            ->format('Y-m');
    }

    public function goToCurrentMonth(): void
    {
        $this->displayMonth = now()->format('Y-m');
    }

    public function moveEvent(int $eventId, string $date): void
    {
        Validator::validate(
            ['date' => $date],
            ['date' => ['required', 'date_format:Y-m-d']],
        );

        $event = ChurchEvent::query()->findOrFail($eventId);
        $targetDate = CarbonImmutable::createFromFormat('!Y-m-d', $date);
        $durationSeconds = $event->ends_at
            ? $event->ends_at->getTimestamp() - $event->starts_at->getTimestamp()
            : null;

        $newStart = $event->starts_at->copy()->setDate(
            $targetDate->year,
            $targetDate->month,
            $targetDate->day,
        );

        $event->starts_at = $newStart;

        if ($durationSeconds !== null) {
            $event->ends_at = $newStart->copy()->addSeconds($durationSeconds);
        }

        $event->save();

        Notification::make()
            ->title('Evento reagendado')
            ->body("{$event->title} movido para {$targetDate->format('d/m/Y')}.")
            ->success()
            ->send();
    }

    protected function getViewData(): array
    {
        $month = CarbonImmutable::createFromFormat('!Y-m', $this->displayMonth)->startOfMonth();
        $calendarStart = $month->startOfWeek(CarbonInterface::SUNDAY);
        $calendarEnd = $month->endOfMonth()->endOfWeek(CarbonInterface::SATURDAY);

        $events = ChurchEvent::query()
            ->whereNot('status', 'canceled')
            ->whereBetween('starts_at', [$calendarStart->startOfDay(), $calendarEnd->endOfDay()])
            ->orderBy('starts_at')
            ->get()
            ->each(fn (ChurchEvent $event) => $event->setAttribute('edit_url', ChurchEventResource::getUrl('edit', ['record' => $event])))
            ->groupBy(fn (ChurchEvent $event): string => $event->starts_at->format('Y-m-d'));

        $days = collect();

        for ($date = $calendarStart; $date->lte($calendarEnd); $date = $date->addDay()) {
            $days->push([
                'date' => $date,
                'inMonth' => $date->month === $month->month,
                'isToday' => $date->isToday(),
                'events' => $events->get($date->format('Y-m-d'), collect()),
            ]);
        }

        return [
            'days' => $days,
            'monthLabel' => ucfirst($month->locale('pt_BR')->translatedFormat('F Y')),
            'createEventUrl' => ChurchEventResource::getUrl('create'),
        ];
    }
}
