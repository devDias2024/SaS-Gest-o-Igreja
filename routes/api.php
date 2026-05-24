<?php

use App\Http\Controllers\Api\ApiDocumentationController;
use App\Http\Controllers\Api\RestResourceController;
use App\Http\Controllers\Api\UniversalCheckInController;
use Illuminate\Support\Facades\Route;

Route::get('/docs/openapi.json', [ApiDocumentationController::class, 'spec'])->name('api.docs.spec');
Route::get('/docs', [ApiDocumentationController::class, 'ui'])->name('api.docs.ui');

Route::middleware('api.key')->prefix('v1')->group(function (): void {
    Route::get('/check-in/{token}', [UniversalCheckInController::class, 'event']);
    Route::post('/check-in/{token}', [UniversalCheckInController::class, 'store']);
    Route::post('/check-in/{token}/offline', [UniversalCheckInController::class, 'syncOffline']);

    Route::get('/{resource}', [RestResourceController::class, 'index']);
    Route::post('/{resource}', [RestResourceController::class, 'store']);
    Route::get('/{resource}/{id}', [RestResourceController::class, 'show'])->whereNumber('id');
    Route::put('/{resource}/{id}', [RestResourceController::class, 'update'])->whereNumber('id');
    Route::patch('/{resource}/{id}', [RestResourceController::class, 'update'])->whereNumber('id');
    Route::delete('/{resource}/{id}', [RestResourceController::class, 'destroy'])->whereNumber('id');
});
