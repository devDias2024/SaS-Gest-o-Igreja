<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Services\EventCheckInService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventCheckInController extends Controller
{
    public function __construct(private readonly EventCheckInService $checkInService)
    {
    }

    public function show(string $token): View
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);

        $this->checkInService->ensureTokenIsValid($event, $session);

        return view('events.check-in', [
            'event' => $event,
            'token' => $token,
            'members' => Member::query()->orderBy('full_name')->limit(300)->get(['id', 'full_name']),
        ]);
    }

    public function qr(string $token): View
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);

        $this->checkInService->ensureTokenIsValid($event, $session);

        return view('events.qr', [
            'event' => $event,
            'checkInUrl' => route('events.check-in.show', $token),
        ]);
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        [$event, $session] = $this->checkInService->resolveEvent($token);

        $this->checkInService->ensureTokenIsValid($event, $session);

        $data = $request->validate([
            'member_id' => ['nullable', 'exists:members,id'],
            'guest_name' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $this->checkInService->register($event, $session, $data);

        return back()->with('status', 'Check-in registrado com sucesso.');
    }
}
