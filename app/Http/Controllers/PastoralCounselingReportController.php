<?php

namespace App\Http\Controllers;

use App\Models\PastoralCounselingCase;
use Illuminate\View\View;

class PastoralCounselingReportController extends Controller
{
    public function demand(): View
    {
        $subjects = PastoralCounselingCase::query()
            ->visibleTo(auth()->user())
            ->whereNotNull('main_subject')
            ->selectRaw('main_subject, count(*) as total')
            ->groupBy('main_subject')
            ->orderByDesc('total')
            ->get();

        $statuses = PastoralCounselingCase::query()
            ->visibleTo(auth()->user())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        return view('pastoral-counseling.reports.demand', [
            'subjects' => $subjects,
            'statuses' => $statuses,
        ]);
    }
}
