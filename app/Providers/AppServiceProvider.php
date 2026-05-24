<?php

namespace App\Providers;

use App\Models\EventCheckIn;
use App\Models\FinancialTransaction;
use App\Models\Member;
use App\Models\MemberCredential;
use App\Models\PastoralCounselingSession;
use App\Models\ProcessFormSubmission;
use App\Services\WebhookDispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Member::created(fn (Member $member) => app(WebhookDispatcher::class)->dispatch('member.created', $member));
        MemberCredential::created(fn (MemberCredential $credential) => app(WebhookDispatcher::class)->dispatch('credential.issued', $credential));

        FinancialTransaction::created(function (FinancialTransaction $transaction): void {
            if ($transaction->type === 'tithe' && $transaction->status !== 'cancelled') {
                app(WebhookDispatcher::class)->dispatch('tithe.received', $transaction);
            }
        });

        EventCheckIn::created(fn (EventCheckIn $checkIn) => app(WebhookDispatcher::class)->dispatch('event.checkin', $checkIn));

        ProcessFormSubmission::created(fn (ProcessFormSubmission $submission) => app(WebhookDispatcher::class)->dispatch('form.submitted', $submission));

        PastoralCounselingSession::created(fn (PastoralCounselingSession $session) => app(WebhookDispatcher::class)->dispatch('counseling.session_scheduled', $session));
    }
}
