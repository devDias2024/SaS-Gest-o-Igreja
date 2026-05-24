<?php

use App\Models\ChurchEvent;
use App\Models\CommunicationMessage;
use App\Models\CommunicationProvider;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Services\EventReminderService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

it('sends event reminders by email and records the delivery', function () {
    Mail::fake();

    CommunicationProvider::create([
        'name' => 'Email',
        'channel' => 'email',
        'driver' => 'smtp',
        'sender_name' => 'Igreja',
        'sender_address' => 'contato@igreja.test',
        'is_active' => true,
    ]);

    $member = Member::create([
        'full_name' => 'Ana Souza',
        'email' => 'ana@example.com',
    ]);
    $event = ChurchEvent::create([
        'title' => 'Culto de domingo',
        'starts_at' => now()->addHours(2),
        'reminder_hours_before' => 3,
        'reminder_channels' => ['email'],
        'status' => 'scheduled',
    ]);
    $registration = EventRegistration::create([
        'church_event_id' => $event->id,
        'member_id' => $member->id,
        'status' => 'confirmed',
    ]);

    $result = app(EventReminderService::class)->sendDueReminders();

    expect($result['sent'])->toBe(1)
        ->and($registration->fresh()->reminder_sent_at)->not->toBeNull()
        ->and(CommunicationMessage::query()->where('channel', 'email')->where('status', 'sent')->exists())->toBeTrue();
});

it('sends whatsapp event reminders through evolution api', function () {
    Http::fake([
        'https://evolution.test/message/sendText/igreja' => Http::response([
            'key' => ['id' => 'message-123'],
        ]),
    ]);

    CommunicationProvider::create([
        'name' => 'WhatsApp',
        'channel' => 'whatsapp',
        'driver' => 'evolution_api',
        'api_base_url' => 'https://evolution.test',
        'settings' => ['instance' => 'igreja', 'api_key' => 'secret'],
        'is_active' => true,
    ]);

    $member = Member::create([
        'full_name' => 'Joao Lima',
        'whatsapp' => '(11) 99888-7766',
    ]);
    $event = ChurchEvent::create([
        'title' => 'Reuniao de jovens',
        'starts_at' => now()->addHour(),
        'reminder_hours_before' => 2,
        'reminder_channels' => ['whatsapp'],
        'status' => 'scheduled',
    ]);
    EventRegistration::create([
        'church_event_id' => $event->id,
        'member_id' => $member->id,
        'status' => 'confirmed',
    ]);

    $result = app(EventReminderService::class)->sendDueReminders();

    expect($result['sent'])->toBe(1)
        ->and(CommunicationMessage::query()->where('external_id', 'message-123')->exists())->toBeTrue();

    Http::assertSent(fn ($request): bool => $request->url() === 'https://evolution.test/message/sendText/igreja'
        && $request['number'] === '11998887766'
        && $request->hasHeader('apikey', 'secret'));
});
