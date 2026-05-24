<?php

namespace App\Services;

use App\Models\WebhookDelivery;
use App\Models\WebhookEndpoint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class WebhookDispatcher
{
    public function dispatch(string $event, Model|array $data): void
    {
        $payload = [
            'event' => $event,
            'occurred_at' => now()->toISOString(),
            'data' => $data instanceof Model ? $data->fresh()?->toArray() ?? $data->toArray() : $data,
        ];

        WebhookEndpoint::query()
            ->where('is_active', true)
            ->get()
            ->filter(fn (WebhookEndpoint $endpoint): bool => $endpoint->listensTo($event))
            ->each(function (WebhookEndpoint $endpoint) use ($event, $payload): void {
                $delivery = WebhookDelivery::query()->create([
                    'webhook_endpoint_id' => $endpoint->id,
                    'event_name' => $event,
                    'payload' => $payload,
                    'status' => 'pending',
                ]);

                try {
                    $signature = hash_hmac('sha256', json_encode($payload), (string) $endpoint->secret);
                    $response = Http::timeout(10)
                        ->withHeaders([
                            'X-SaaS-Igreja-Event' => $event,
                            'X-SaaS-Igreja-Signature' => $signature,
                        ])
                        ->post($endpoint->url, $payload);

                    $delivery->update([
                        'status_code' => $response->status(),
                        'response_body' => substr($response->body(), 0, 5000),
                        'status' => $response->successful() ? 'delivered' : 'failed',
                        'delivered_at' => now(),
                    ]);
                } catch (\Throwable $exception) {
                    $delivery->update([
                        'status' => 'failed',
                        'error_message' => $exception->getMessage(),
                        'delivered_at' => now(),
                    ]);
                }
            });
    }
}
