<?php

namespace App\Http\Controllers;

use App\Models\ProcessForm;
use Illuminate\View\View;

class ProcessFormDashboardController extends Controller
{
    public function show(ProcessForm $processForm): View
    {
        $submissions = $processForm->submissions()
            ->latest('submitted_at')
            ->get();

        $statusCounts = $submissions
            ->groupBy('status')
            ->map->count()
            ->all();

        $dailyCounts = $submissions
            ->filter(fn ($submission) => filled($submission->submitted_at))
            ->groupBy(fn ($submission) => $submission->submitted_at->format('d/m/Y'))
            ->map->count()
            ->take(14)
            ->all();

        $questionReport = collect($processForm->fields ?? [])
            ->map(function (array $field) use ($submissions): array {
                $key = $field['data']['key'] ?? null;
                $label = $field['data']['label'] ?? $key;

                if (! $key) {
                    return [];
                }

                $answers = $submissions
                    ->map(fn ($submission) => $submission->answers[$key] ?? null)
                    ->filter(fn ($answer) => filled($answer) || is_array($answer));

                $options = $answers
                    ->flatMap(fn ($answer) => is_array($answer) ? $answer : [$answer])
                    ->filter()
                    ->countBy()
                    ->sortDesc()
                    ->all();

                return [
                    'key' => $key,
                    'label' => $label,
                    'answered' => $answers->count(),
                    'empty' => max($submissions->count() - $answers->count(), 0),
                    'options' => $options,
                ];
            })
            ->filter()
            ->values();

        return view('process-forms.dashboard', [
            'form' => $processForm,
            'total' => $submissions->count(),
            'statusCounts' => $statusCounts,
            'dailyCounts' => $dailyCounts,
            'questionReport' => $questionReport,
        ]);
    }
}
