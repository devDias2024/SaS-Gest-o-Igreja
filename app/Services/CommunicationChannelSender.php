<?php

namespace App\Services;

use App\Models\CommunicationMessage;
use App\Models\CommunicationProvider;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use RuntimeException;

class CommunicationChannelSender
{
    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    public function send(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        return match ($provider->driver) {
            'smtp' => $this->sendEmail($message, $provider),
            'twilio' => $this->sendTwilio($message, $provider),
            'evolution_api' => $this->sendEvolutionApi($message, $provider),
            'whatsapp_official' => $this->sendWhatsAppOfficial($message, $provider),
            'custom_webhook' => $this->sendCustomWebhook($message, $provider),
            default => throw new RuntimeException('O provedor selecionado nao possui envio automatico configurado.'),
        };
    }

    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    protected function sendEmail(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        if ($message->channel !== 'email') {
            throw new RuntimeException('O provedor SMTP so pode enviar mensagens de e-mail.');
        }

        Mail::raw($message->body, function ($mail) use ($message, $provider): void {
            $mail->to($message->recipient_contact, $message->recipient_name)
                ->subject($message->subject ?: 'Lembrete de evento');

            if (filled($provider->sender_address)) {
                $mail->from($provider->sender_address, $provider->sender_name);
            }
        });

        return ['external_id' => null, 'payload' => ['mailer' => config('mail.default')]];
    }

    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    protected function sendTwilio(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        $settings = $provider->settings ?? [];
        $accountSid = $settings['account_sid'] ?? null;
        $authToken = $settings['auth_token'] ?? null;

        if (blank($accountSid) || blank($authToken) || blank($provider->sender_address)) {
            throw new RuntimeException('Informe account_sid, auth_token e remetente no provedor Twilio.');
        }

        $prefix = $message->channel === 'whatsapp' ? 'whatsapp:' : '';
        $response = Http::asForm()
            ->withBasicAuth($accountSid, $authToken)
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'From' => $prefix.$provider->sender_address,
                'To' => $prefix.$message->recipient_contact,
                'Body' => $message->body,
            ]);

        $this->ensureSuccessful($response, 'Twilio');

        return [
            'external_id' => $response->json('sid'),
            'payload' => $response->json() ?? [],
        ];
    }

    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    protected function sendEvolutionApi(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        $settings = $provider->settings ?? [];
        $instance = $settings['instance'] ?? null;
        $apiKey = $settings['api_key'] ?? null;

        if (blank($provider->api_base_url) || blank($instance) || blank($apiKey)) {
            throw new RuntimeException('Informe URL da API, instance e api_key no provedor Evolution API.');
        }

        $url = rtrim($provider->api_base_url, '/').'/message/sendText/'.$instance;
        $response = Http::withHeaders(['apikey' => $apiKey])->post($url, [
            'number' => $this->onlyDigits($message->recipient_contact),
            'text' => $message->body,
        ]);

        $this->ensureSuccessful($response, 'Evolution API');

        return [
            'external_id' => $response->json('key.id') ?? $response->json('messageId'),
            'payload' => $response->json() ?? [],
        ];
    }

    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    protected function sendWhatsAppOfficial(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        $settings = $provider->settings ?? [];
        $token = $settings['access_token'] ?? null;
        $phoneNumberId = $settings['phone_number_id'] ?? null;
        $graphVersion = $settings['graph_version'] ?? 'v22.0';

        if (blank($token) || blank($phoneNumberId)) {
            throw new RuntimeException('Informe access_token e phone_number_id no provedor WhatsApp Oficial.');
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->onlyDigits($message->recipient_contact),
        ];

        if (filled($settings['template_name'] ?? null)) {
            $payload += [
                'type' => 'template',
                'template' => [
                    'name' => $settings['template_name'],
                    'language' => ['code' => $settings['language_code'] ?? 'pt_BR'],
                ],
            ];
        } else {
            $payload += [
                'type' => 'text',
                'text' => ['body' => $message->body],
            ];
        }

        $baseUrl = rtrim($provider->api_base_url ?: 'https://graph.facebook.com', '/');
        $response = Http::withToken($token)->post("{$baseUrl}/{$graphVersion}/{$phoneNumberId}/messages", $payload);

        $this->ensureSuccessful($response, 'WhatsApp Oficial');

        return [
            'external_id' => $response->json('messages.0.id'),
            'payload' => $response->json() ?? [],
        ];
    }

    /**
     * @return array{external_id: string|null, payload: array<string, mixed>}
     */
    protected function sendCustomWebhook(CommunicationMessage $message, CommunicationProvider $provider): array
    {
        if (blank($provider->api_base_url)) {
            throw new RuntimeException('Informe a URL da API para o webhook customizado.');
        }

        $settings = $provider->settings ?? [];
        $request = Http::acceptJson();

        if (filled($settings['bearer_token'] ?? null)) {
            $request = $request->withToken($settings['bearer_token']);
        }

        if (filled($settings['api_key'] ?? null)) {
            $request = $request->withHeaders([
                $settings['api_key_header'] ?? 'X-Api-Key' => $settings['api_key'],
            ]);
        }

        $response = $request->post($provider->api_base_url, [
            'channel' => $message->channel,
            'to' => $message->recipient_contact,
            'name' => $message->recipient_name,
            'subject' => $message->subject,
            'message' => $message->body,
            'metadata' => $message->payload,
        ]);

        $this->ensureSuccessful($response, 'Webhook');

        return [
            'external_id' => $response->json('id') ?? $response->json('message_id'),
            'payload' => $response->json() ?? [],
        ];
    }

    protected function ensureSuccessful(Response $response, string $provider): void
    {
        if ($response->successful()) {
            return;
        }

        throw new RuntimeException("Falha na API {$provider}: HTTP {$response->status()} - ".str($response->body())->limit(180));
    }

    protected function onlyDigits(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone) ?: $phone;
    }
}
