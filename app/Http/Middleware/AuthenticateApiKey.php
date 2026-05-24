<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\ApiRequestLog;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    public function __construct(private readonly RateLimiter $limiter)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $startedAt = microtime(true);
        $token = $request->bearerToken() ?: $request->header('X-API-Key');

        if (! $token) {
            return response()->json(['message' => 'API key ausente.'], 401);
        }

        $apiKey = ApiKey::query()->where('key_hash', ApiKey::hashToken($token))->first();

        if (! $apiKey || ! $apiKey->isUsableFrom($request->ip())) {
            return response()->json(['message' => 'API key invalida ou inativa.'], 401);
        }

        $rateKey = 'api-key:'.$apiKey->id.':'.now()->format('YmdHi');
        if ($this->limiter->tooManyAttempts($rateKey, $apiKey->rate_limit_per_minute)) {
            return response()->json(['message' => 'Limite de requisicoes excedido.'], 429);
        }

        $this->limiter->hit($rateKey, 60);
        $request->attributes->set('api_key', $apiKey);
        $apiKey->forceFill(['last_used_at' => now()])->save();

        $response = $next($request);

        ApiRequestLog::query()->create([
            'api_key_id' => $apiKey->id,
            'method' => $request->method(),
            'path' => $request->path(),
            'ip_address' => $request->ip(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            'user_agent' => $request->userAgent(),
            'request_payload' => $request->except(['password', 'token', 'api_key']),
            'response_payload' => $response->headers->get('content-type') && str_contains($response->headers->get('content-type'), 'json')
                ? json_decode($response->getContent(), true)
                : null,
        ]);

        $response->headers->set('X-RateLimit-Limit', (string) $apiKey->rate_limit_per_minute);
        $response->headers->set('X-RateLimit-Remaining', (string) max(0, $apiKey->rate_limit_per_minute - $this->limiter->attempts($rateKey)));

        return $response;
    }
}
