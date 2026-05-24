<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EventCheckInService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UniversalCheckInController extends Controller
{
    public function __construct(private readonly EventCheckInService $checkInService)
    {
    }

    public function event(string $token): JsonResponse
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);
        $this->checkInService->ensureTokenIsValid($event, $session);

        return response()->json([
            'event' => $event->load('location'),
            'check_in' => [
                'token' => $token,
                'dynamic' => (bool) $session,
                'expires_at' => $session?->expires_at,
                'allows_member_app' => (bool) $event->allows_member_app_check_in,
                'allows_offline' => (bool) $event->allows_offline_check_in,
                'geofencing_enabled' => (bool) $event->geofencing_enabled,
            ],
        ]);
    }

    public function store(Request $request, string $token): JsonResponse
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);
        $this->checkInService->ensureTokenIsValid($event, $session);

        $data = $request->validate([
            'member_id' => ['nullable', 'exists:members,id'],
            'event_registration_id' => ['nullable', 'exists:event_registrations,id'],
            'guest_name' => ['nullable', 'string', 'max:255'],
            'method' => ['nullable', 'in:manual,qr_code,member_app,geofence,offline'],
            'checked_in_at' => ['nullable', 'date'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'device_id' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $checkIn = $this->checkInService->register($event, $session, array_merge($data, [
            'qr_token' => $token,
        ]));

        return response()->json([
            'message' => 'Check-in registrado com sucesso.',
            'check_in' => $checkIn->fresh(['event', 'member', 'registration']),
        ], 201);
    }

    public function syncOffline(Request $request, string $token): JsonResponse
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);
        $this->checkInService->ensureTokenIsValid($event, $session);

        $data = $request->validate([
            'device_id' => ['nullable', 'string', 'max:255'],
            'uploaded_by' => ['nullable', 'string', 'max:255'],
            'records' => ['required', 'array'],
            'records.*.member_id' => ['nullable', 'integer'],
            'records.*.event_registration_id' => ['nullable', 'integer'],
            'records.*.guest_name' => ['nullable', 'string', 'max:255'],
            'records.*.checked_in_at' => ['nullable', 'date'],
            'records.*.latitude' => ['nullable', 'numeric'],
            'records.*.longitude' => ['nullable', 'numeric'],
            'records.*.device_id' => ['nullable', 'string', 'max:255'],
            'records.*.notes' => ['nullable', 'string'],
        ]);

        $batch = $this->checkInService->syncOffline($event, array_merge($data, ['token' => $token]), $data['device_id'] ?? null, $data['uploaded_by'] ?? null);

        return response()->json([
            'message' => 'Lote offline sincronizado.',
            'batch' => $batch,
        ], 201);
    }
}
