<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use App\Services\PanelPermissionService;
use Carbon\Carbon;
use Filament\Widgets\Widget;

class MemberHighlights extends Widget
{
    protected static ?int $sort = 3;

    protected string $view = 'filament.widgets.member-highlights';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return app(PanelPermissionService::class)->allows(auth()->user(), 'Gestao de Membros', 'view');
    }

    protected function getViewData(): array
    {
        $today = today();
        $membersWithBirthDate = Member::query()
            ->whereNotNull('birth_date')
            ->get(['id', 'full_name', 'preferred_name', 'birth_date']);

        $birthdaysToday = $membersWithBirthDate
            ->filter(fn (Member $member): bool => $member->birth_date->isBirthday($today))
            ->sortBy('full_name')
            ->values();

        $upcomingBirthdays = $membersWithBirthDate
            ->map(function (Member $member) use ($today): array {
                $lastDayOfBirthdayMonth = Carbon::create($today->year, $member->birth_date->month, 1)
                    ->endOfMonth()
                    ->day;
                $nextBirthday = Carbon::create(
                    $today->year,
                    $member->birth_date->month,
                    min($member->birth_date->day, $lastDayOfBirthdayMonth),
                )->startOfDay();

                if ($nextBirthday->lt($today)) {
                    $nextBirthday->addYear();
                }

                return ['member' => $member, 'date' => $nextBirthday];
            })
            ->filter(fn (array $birthday): bool => $birthday['date']->lte($today->copy()->addDays(45)))
            ->sortBy('date')
            ->take(6)
            ->values();

        return [
            'birthdaysToday' => $birthdaysToday,
            'upcomingBirthdays' => $upcomingBirthdays,
        ];
    }
}
