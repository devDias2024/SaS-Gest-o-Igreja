<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\SundaySchoolCertificate;
use Illuminate\View\View;

class SundaySchoolCertificateController extends Controller
{
    public function print(SundaySchoolCertificate $certificate): View
    {
        $certificate->load('enrollment.member', 'enrollment.class.teacher');

        return view('sunday-school.certificates.print', [
            'certificate' => $certificate,
            'validationUrl' => route('sunday-school.certificates.validate', $certificate->validation_token),
        ]);
    }

    public function validateCertificate(string $token): View
    {
        return view('sunday-school.certificates.validate', [
            'certificate' => SundaySchoolCertificate::query()
                ->with('enrollment.member', 'enrollment.class')
                ->where('validation_token', $token)
                ->firstOrFail(),
        ]);
    }

    public function history(Member $member): View
    {
        return view('sunday-school.history', [
            'member' => $member,
            'enrollments' => $member->sundaySchoolEnrollments()->with('class', 'certificate')->latest('enrolled_on')->get(),
        ]);
    }
}
