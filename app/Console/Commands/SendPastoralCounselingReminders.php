<?php

namespace App\Console\Commands;

use App\Models\PastoralCounselingSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendPastoralCounselingReminders extends Command
{
    protected $signature = 'pastoral-counseling:send-reminders';

    protected $description = 'Envia lembretes de sessoes de aconselhamento pastoral.';

    public function handle(): int
    {
        $sessions = PastoralCounselingSession::query()
            ->with('case.member')
            ->where('status', 'scheduled')
            ->whereNotNull('reminder_at')
            ->whereNull('reminder_sent_at')
            ->where('reminder_at', '<=', now())
            ->get();

        foreach ($sessions as $session) {
            $member = $session->case?->member;

            if (filled($member?->email)) {
                try {
                    Mail::raw(
                        'Lembrete: sua sessao de aconselhamento pastoral esta agendada para '.$session->scheduled_at->format('d/m/Y H:i').'.',
                        fn ($message) => $message->to($member->email)->subject('Lembrete de aconselhamento pastoral'),
                    );
                } catch (Throwable) {
                    report('Falha ao enviar lembrete de aconselhamento pastoral.');
                }
            }

            $session->update(['reminder_sent_at' => now()]);
        }

        $this->info($sessions->count().' lembrete(s) processado(s).');

        return self::SUCCESS;
    }
}
