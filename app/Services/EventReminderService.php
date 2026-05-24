<?php

namespace App\Services;

use App\Models\ChurchEvent;
use App\Models\CommunicationMessage;
use App\Models\CommunicationProvider;
use App\Models\CommunicationTemplate;
use App\Models\EventRegistration;
use Throwable;

class EventReminderService
{
    public function __construct(protected CommunicationChannelSender $sender) {}

    /**
     * @return array{events: int, registrations: int, sent: int, failed: int, skipped: int}
     */
    public function sendDueReminders(): array
    {
        $result = ['events' => 0, 'registrations' => 0, 'sent' => 0, 'failed' => 0, 'skipped' => 0];

        $events = ChurchEvent::query()
            ->whereIn('status', ['scheduled', 'open'])
            ->whereNotNull('reminder_hours_before')
            ->whereNotNull('reminder_channels')
            ->where('starts_at', '>', now())
            ->get()
            ->filter(fn (ChurchEvent $event): bool => $event->starts_at
                ->copy()
                ->subHours((int) $event->reminder_hours_before)
                ->lte(now()));

        foreach ($events as $event) {
            $channels = array_values(array_intersect($event->reminder_channels ?? [], ['email', 'sms', 'whatsapp']));

            if ($channels === []) {
                continue;
            }

            $result['events']++;
            $statuses = $event->registration_confirmation_required ? ['confirmed'] : ['pending', 'confirmed'];
            $registrations = EventRegistration::query()
                ->with('member')
                ->where('church_event_id', $event->id)
                ->whereIn('status', $statuses)
                ->whereNull('reminder_sent_at')
                ->get();

            foreach ($registrations as $registration) {
                $result['registrations']++;
                $registrationCompleted = true;

                foreach ($channels as $channel) {
                    $contact = $this->contactFor($registration, $channel);

                    if (blank($contact)) {
                        $result['skipped']++;

                        continue;
                    }

                    if ($this->wasAlreadySent($event, $registration, $channel)) {
                        continue;
                    }

                    if ($this->sendReminder($event, $registration, $channel, $contact)) {
                        $result['sent']++;
                    } else {
                        $result['failed']++;
                        $registrationCompleted = false;
                    }
                }

                if ($registrationCompleted) {
                    $registration->update(['reminder_sent_at' => now()]);
                }
            }
        }

        return $result;
    }

    protected function sendReminder(
        ChurchEvent $event,
        EventRegistration $registration,
        string $channel,
        string $contact,
    ): bool {
        $provider = CommunicationProvider::query()
            ->where('channel', $channel)
            ->where('is_active', true)
            ->orderBy('id')
            ->first();
        $template = CommunicationTemplate::query()
            ->where('channel', $channel)
            ->where('category', 'event')
            ->where('is_active', true)
            ->orderBy('id')
            ->first();
        $name = $registration->member?->full_name ?: ($registration->guest_name ?: 'Participante');
        $message = $this->messageRecord($event, $registration, $provider, $template, $channel, $contact, $name);

        if (! $provider) {
            $message->update([
                'status' => 'failed',
                'error_message' => 'Nenhum provedor ativo configurado para este canal.',
            ]);

            return false;
        }

        try {
            $delivery = $this->sender->send($message, $provider);
            $message->update([
                'status' => 'sent',
                'sent_at' => now(),
                'external_id' => $delivery['external_id'],
                'payload' => array_merge($message->payload ?? [], ['provider_response' => $delivery['payload']]),
                'error_message' => null,
            ]);

            return true;
        } catch (Throwable $exception) {
            $message->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);

            report($exception);

            return false;
        }
    }

    protected function messageRecord(
        ChurchEvent $event,
        EventRegistration $registration,
        ?CommunicationProvider $provider,
        ?CommunicationTemplate $template,
        string $channel,
        string $contact,
        string $name,
    ): CommunicationMessage {
        $variables = [
            '{{nome}}' => $name,
            '{{evento}}' => $event->title,
            '{{data}}' => $event->starts_at->format('d/m/Y'),
            '{{hora}}' => $event->starts_at->format('H:i'),
        ];
        $subject = $template?->subject ?: "Lembrete: {$event->title}";
        $body = $template?->body
            ?: 'Ola {{nome}}, lembramos que o evento {{evento}} sera em {{data}} as {{hora}}.';

        $message = CommunicationMessage::query()
            ->where('channel', $channel)
            ->where('payload->church_event_id', $event->id)
            ->where('payload->event_registration_id', $registration->id)
            ->latest('id')
            ->first() ?? new CommunicationMessage;

        $message->fill([
            'communication_template_id' => $template?->id,
            'communication_provider_id' => $provider?->id,
            'member_id' => $registration->member_id,
            'direction' => 'outbound',
            'channel' => $channel,
            'recipient_name' => $name,
            'recipient_contact' => $contact,
            'subject' => strtr($subject, $variables),
            'body' => strtr($body, $variables),
            'status' => 'queued',
            'scheduled_at' => now(),
            'payload' => [
                'church_event_id' => $event->id,
                'event_registration_id' => $registration->id,
            ],
        ])->save();

        return $message;
    }

    protected function wasAlreadySent(ChurchEvent $event, EventRegistration $registration, string $channel): bool
    {
        return CommunicationMessage::query()
            ->where('channel', $channel)
            ->where('status', 'sent')
            ->where('payload->church_event_id', $event->id)
            ->where('payload->event_registration_id', $registration->id)
            ->exists();
    }

    protected function contactFor(EventRegistration $registration, string $channel): ?string
    {
        return match ($channel) {
            'email' => $registration->member?->email ?: $registration->guest_email,
            'sms' => $registration->member?->phone ?: $registration->guest_phone,
            'whatsapp' => $registration->member?->whatsapp ?: ($registration->member?->phone ?: $registration->guest_phone),
            default => null,
        };
    }
}
