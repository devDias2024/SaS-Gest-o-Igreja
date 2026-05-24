<?php

namespace App\Http\Controllers;

use App\Models\SundaySchoolEnrollment;
use Illuminate\View\View;

class SundaySchoolReportController extends Controller
{
    public function approvals(): View
    {
        $statusCounts = SundaySchoolEnrollment::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $classes = SundaySchoolEnrollment::query()
            ->with('class')
            ->selectRaw('sunday_school_class_id, status, count(*) as total')
            ->groupBy('sunday_school_class_id', 'status')
            ->get()
            ->groupBy('sunday_school_class_id');

        return view('sunday-school.reports.approvals', [
            'statusCounts' => $statusCounts,
            'classes' => $classes,
        ]);
    }
}
