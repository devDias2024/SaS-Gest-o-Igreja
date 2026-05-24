<?php

namespace App\Services;

use App\Models\CommunicationInboxThread;
use App\Models\CommunicationMessage;

class PublicSiteCommunication
{
    public function registerInboundLead(
        string $name,
        ?string $email,
        ?string $phone,
        string $subject,
        string $body,
        array $metadata = [],
    ): CommunicationInboxThread {
        $contact = $email ?: $phone ?: 'site-publico';

        $thread = CommunicationInboxThread::create([
            'channel' => $email ? 'email' : 'whatsapp',
            'external_contact' => $contact,
            'contact_name' => $name,
            'subject' => $subject,
            'status' => 'open',
            'unread_count' => 1,
            'last_message_at' => now(),
            'last_message_preview' => str($body)->limit(160)->toString(),
            'metadata' => $metadata,
        ]);

        CommunicationMessage::create([
            'communication_inbox_thread_id' => $thread->id,
            'direction' => 'inbound',
            'channel' => $email ? 'email' : 'whatsapp',
            'recipient_name' => $name,
            'recipient_contact' => $contact,
            'subject' => $subject,
            'body' => $body,
            'status' => 'received',
            'payload' => $metadata,
        ]);

        return $thread;
    }
}
