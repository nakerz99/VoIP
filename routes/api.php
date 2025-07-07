<?php

use App\Http\Controllers\Api\VoipWebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| VOIP Integration API Routes
|--------------------------------------------------------------------------
|
| These routes handle webhooks and API calls from VOIP systems like 3CX.
| In production, these should be secured with proper authentication.
|
*/

Route::prefix('voip')->group(function () {
    // Test endpoint for VOIP integration
    Route::post('/test', [VoipWebhookController::class, 'test'])
        ->name('api.voip.test');
    
    // Webhook endpoints for 3CX integration
    Route::post('/incoming-call', [VoipWebhookController::class, 'incomingCall'])
        ->name('api.voip.incoming-call');
    
    Route::post('/call-status-update', [VoipWebhookController::class, 'callStatusUpdate'])
        ->name('api.voip.call-status-update');
    
    Route::post('/agent-status-update', [VoipWebhookController::class, 'agentStatusUpdate'])
        ->name('api.voip.agent-status-update');
    
    Route::post('/call-ended', [VoipWebhookController::class, 'callEnded'])
        ->name('api.voip.call-ended');
});

/*
|--------------------------------------------------------------------------
| Future API Endpoints
|--------------------------------------------------------------------------
|
| Placeholder for additional API endpoints that may be needed:
| - Agent management API
| - Call statistics API
| - Real-time dashboard updates
| - Mobile app integration
|
*/
