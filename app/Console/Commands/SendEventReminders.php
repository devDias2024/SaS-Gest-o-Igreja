<?php

namespace App\Console\Commands;

use App\Services\EventReminderService;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    protected $signature = 'events:send-reminders';

    protected $description = 'Envia lembretes de eventos pelos canais configurados.';

    public function handle(EventReminderService $reminders): int
    {
        $result = $reminders->sendDueReminders();

        $this->info(
            "{$result['events']} evento(s), {$result['registrations']} inscricao(oes), ".
            "{$result['sent']} envio(s), {$result['failed']} falha(s), {$result['skipped']} sem contato.",
        );

        return self::SUCCESS;
    }
}
