<?php

namespace App\Http\Controllers;

use App\Models\SiteLiveChatMessage;
use App\Models\SiteLiveViewer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SiteLiveChatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->touchViewer($request);

        $messages = SiteLiveChatMessage::query()
            ->where('is_approved', true)
            ->latest()
            ->limit(40)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (SiteLiveChatMessage $message): array => [
                'id' => $message->id,
                'name' => $message->name,
                'message' => $message->message,
                'time' => $message->created_at?->diffForHumans(),
            ]);

        return response()->json([
            'messages' => $messages,
            'online_count' => $this->onlineCount(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->touchViewer($request);

        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:600'],
        ]);

        $message = SiteLiveChatMessage::query()->create([
            'name' => filled($data['name'] ?? null) ? $data['name'] : 'Visitante',
            'message' => $data['message'],
            'is_approved' => true,
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'name' => $message->name,
                'message' => $message->message,
                'time' => 'agora',
            ],
            'online_count' => $this->onlineCount(),
        ], 201);
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $this->touchViewer($request);

        return response()->json(['online_count' => $this->onlineCount()]);
    }

    private function touchViewer(Request $request): void
    {
        SiteLiveViewer::query()->updateOrCreate(
            ['session_id' => $request->session()->getId()],
            [
                'ip_address' => $request->ip(),
                'user_agent' => (string) $request->userAgent(),
                'last_seen_at' => now(),
            ],
        );
    }

    private function onlineCount(): int
    {
        SiteLiveViewer::query()
            ->where('last_seen_at', '<', now()->subMinutes(2))
            ->delete();

        return SiteLiveViewer::query()
            ->where('last_seen_at', '>=', now()->subMinutes(2))
            ->count();
    }
}
