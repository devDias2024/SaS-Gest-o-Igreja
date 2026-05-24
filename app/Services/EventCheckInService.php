<?php

namespace App\Services;

use App\Models\ChurchEvent;
use App\Models\EventCheckIn;
use App\Models\EventCheckInSession;
use App\Models\OfflineCheckInBatch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EventCheckInService
{
    /**
     * @return array{0: ChurchEvent|null, 1: EventCheckInSession|null}
     */
    public function resolveEvent(string $token): array
    {
        $event = ChurchEvent::query()->where('check_in_token', $token)->first();

        if ($event) {
            return [$event, null];
        }

        $session = EventCheckInSession::query()
            ->with('event.location')
            ->where('token', $token)
            ->first();

        return [$session?->event, $session];
    }

    public function ensureTokenIsValid(?ChurchEvent $event, ?EventCheckInSession $session): void
    {
        abort_if(! $event, 404, 'Evento nao encontrado.');
        abort_if($session && (! $session->is_active || $session->expires_at->isPast()), 403, 'QR Code expirado ou inativo.');
    }

    public function register(ChurchEvent $event, ?EventCheckInSession $session, array $data): EventCheckIn
    {
        $method = $data['method'] ?? ($session ? 'member_app' : 'qr_code');

        if ($method === 'member_app' && ! $event->allows_member_app_check_in) {
            abort(403, 'Este evento nao permite check-in pelo app.');
        }

        if ($method === 'offline' && ! $event->allows_offline_check_in) {
            abort(403, 'Este evento nao permite sincronizacao offline.');
        }

        $checkIn = $event->checkIns()->create([
            'member_id' => $data['member_id'] ?? null,
            'event_registration_id' => $data['event_registration_id'] ?? null,
            'guest_name' => $data['guest_name'] ?? null,
            'method' => $method,
            'checked_in_at' => isset($data['checked_in_at']) ? Carbon::parse($data['checked_in_at']) : now(),
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'inside_geofence' => $this->insideGeofence($event, $data['latitude'] ?? null, $data['longitude'] ?? null),
            'device_id' => $data['device_id'] ?? null,
            'qr_token' => $data['qr_token'] ?? ($session?->token ?? $event->check_in_token),
            'synced_from_offline' => (bool) ($data['synced_from_offline'] ?? false),
            'notes' => $data['notes'] ?? null,
        ]);

        if ($checkIn->registration) {
            $checkIn->registration->update([
                'status' => 'checked_in',
                'confirmed_at' => $checkIn->registration->confirmed_at ?? now(),
            ]);
        }

        return $checkIn;
    }

    public function syncOffline(ChurchEvent $event, array $payload, ?string $deviceId = null, ?string $uploadedBy = null): OfflineCheckInBatch
    {
        if (! $event->allows_offline_check_in) {
            abort(403, 'Este evento nao permite sincronizacao offline.');
        }

        $records = $payload['records'] ?? [];
        $processed = 0;
        $failed = 0;
        $errors = [];

        $batch = OfflineCheckInBatch::query()->create([
            'church_event_id' => $event->id,
            'device_id' => $deviceId,
            'uploaded_by' => $uploadedBy,
            'payload' => $payload,
            'records_count' => count($records),
            'processed_count' => 0,
            'failed_count' => 0,
            'status' => 'pending',
        ]);

        foreach ($records as $index => $record) {
            try {
                $validated = Validator::make($record, [
                    'member_id' => ['nullable', 'exists:members,id'],
                    'event_registration_id' => ['nullable', 'exists:event_registrations,id'],
                    'guest_name' => ['nullable', 'string', 'max:255'],
                    'checked_in_at' => ['nullable', 'date'],
                    'latitude' => ['nullable', 'numeric'],
                    'longitude' => ['nullable', 'numeric'],
                    'notes' => ['nullable', 'string'],
                ])->validate();

                $this->register($event, null, array_merge($validated, [
                    'method' => 'offline',
                    'device_id' => $record['device_id'] ?? $deviceId,
                    'qr_token' => $payload['token'] ?? $event->check_in_token,
                    'synced_from_offline' => true,
                ]));

                $processed++;
            } catch (\Throwable $exception) {
                $failed++;
                $errors[] = ['index' => $index, 'message' => $exception instanceof ValidationException ? $exception->getMessage() : $exception->getMessage()];
            }
        }

        $batch->update([
            'processed_count' => $processed,
            'failed_count' => $failed,
            'status' => $failed > 0 ? ($processed > 0 ? 'processed_with_errors' : 'failed') : 'processed',
            'processed_at' => now(),
            'error_message' => $errors === [] ? null : json_encode($errors, JSON_UNESCAPED_UNICODE),
        ]);

        return $batch->fresh();
    }

    public function insideGeofence(ChurchEvent $event, mixed $latitude, mixed $longitude): ?bool
    {
        if (! $event->geofencing_enabled || ! $latitude || ! $longitude) {
            return null;
        }

        $location = $event->location;

        if (! $location?->latitude || ! $location?->longitude) {
            return null;
        }

        $earthRadius = 6371000;
        $latFrom = deg2rad((float) $latitude);
        $lonFrom = deg2rad((float) $longitude);
        $latTo = deg2rad((float) $location->latitude);
        $lonTo = deg2rad((float) $location->longitude);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            (sin($latDelta / 2) ** 2) +
            cos($latFrom) * cos($latTo) * (sin($lonDelta / 2) ** 2)
        ));

        return ($angle * $earthRadius) <= $location->geofence_radius_meters;
    }
}
