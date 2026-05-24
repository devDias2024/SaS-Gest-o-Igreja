<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ApiDocumentationController extends Controller
{
    public function spec(): JsonResponse
    {
        return response()->json([
            'openapi' => '3.0.3',
            'info' => [
                'title' => 'SaaS Igreja API',
                'version' => '1.0.0',
                'description' => 'API publica para integracoes externas do SaaS Igreja.',
            ],
            'servers' => [['url' => url('/api/v1')]],
            'components' => [
                'securitySchemes' => [
                    'ApiKey' => ['type' => 'http', 'scheme' => 'bearer'],
                    'ApiKeyHeader' => ['type' => 'apiKey', 'in' => 'header', 'name' => 'X-API-Key'],
                ],
            ],
            'security' => [['ApiKey' => []]],
            'paths' => array_merge($this->checkInPaths(), $this->paths()),
        ]);
    }

    public function ui(): View
    {
        return view('api.docs');
    }

    private function paths(): array
    {
        $resources = [
            'members',
            'member-categories',
            'member-tags',
            'member-credentials',
            'member-credential-templates',
            'financial-transactions',
            'financial-pledges',
            'online-donations',
            'events',
            'event-registrations',
            'event-checkins',
            'child-profiles',
            'child-checkins',
            'forms',
            'form-submissions',
            'counseling-cases',
            'counseling-sessions',
            'sunday-school-classes',
            'sunday-school-enrollments',
            'sunday-school-attendances',
            'sunday-school-grades',
            'sunday-school-certificates',
            'assets',
            'stock-movements',
            'dining-menus',
            'meal-services',
            'dietary-restrictions',
            'food-donations',
            'social-pantry-distributions',
            'sermons',
            'blog-posts',
            'site-pages',
        ];
        $paths = [];

        foreach ($resources as $resource) {
            $paths["/{$resource}"] = [
                'get' => ['summary' => "Listar {$resource}", 'responses' => ['200' => ['description' => 'OK']]],
                'post' => ['summary' => "Criar {$resource}", 'responses' => ['201' => ['description' => 'Criado']]],
            ];
            $paths["/{$resource}/{id}"] = [
                'get' => ['summary' => "Detalhar {$resource}", 'parameters' => [$this->idParam()], 'responses' => ['200' => ['description' => 'OK']]],
                'put' => ['summary' => "Atualizar {$resource}", 'parameters' => [$this->idParam()], 'responses' => ['200' => ['description' => 'OK']]],
                'delete' => ['summary' => "Excluir {$resource}", 'parameters' => [$this->idParam()], 'responses' => ['200' => ['description' => 'OK']]],
            ];
        }

        return $paths;
    }

    private function checkInPaths(): array
    {
        return [
            '/check-in/{token}' => [
                'get' => [
                    'summary' => 'Detalhar evento de check-in por token/QR',
                    'parameters' => [['name' => 'token', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]],
                    'responses' => ['200' => ['description' => 'OK']],
                ],
                'post' => [
                    'summary' => 'Registrar check-in universal pelo app, QR ou geofence',
                    'parameters' => [['name' => 'token', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]],
                    'responses' => ['201' => ['description' => 'Registrado']],
                ],
            ],
            '/check-in/{token}/offline' => [
                'post' => [
                    'summary' => 'Sincronizar lote de check-ins offline de um dispositivo',
                    'parameters' => [['name' => 'token', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]],
                    'responses' => ['201' => ['description' => 'Lote sincronizado']],
                ],
            ],
        ];
    }

    private function idParam(): array
    {
        return ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'integer']];
    }
}
