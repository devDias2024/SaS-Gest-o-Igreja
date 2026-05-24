<?php

namespace App\Http\Controllers;

use App\Models\ChildCheckIn;
use Illuminate\View\View;

class ChildCheckInLabelController extends Controller
{
    public function show(ChildCheckIn $childCheckIn): View
    {
        $childCheckIn->update(['label_printed_at' => now()]);

        return view('children.check-in-label', [
            'checkIn' => $childCheckIn->load(['child', 'ageGroup', 'checkedInBy']),
        ]);
    }
}
