<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Paystack API routes for subscription payments
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/paystack/initialize', [App\Http\Controllers\SubscriptionController::class, 'initializeApi']);
    Route::get('/paystack/callback', [App\Http\Controllers\SubscriptionController::class, 'callbackApi']);
});

// Distribution API routes
Route::prefix('distribution')->name('distribution.')->group(function () {
    // Webhook endpoints (no authentication required)
    Route::post('/webhooks/delivery-status', [App\Http\Controllers\Api\Distribution\WebhookController::class, 'deliveryStatus'])
        ->middleware('throttle:120,1') // 120 requests per minute for webhooks
        ->name('webhooks.delivery-status');
    
    Route::post('/webhooks/royalties', [App\Http\Controllers\Api\Distribution\WebhookController::class, 'royalties'])
        ->middleware('throttle:120,1')
        ->name('webhooks.royalties');

    // Authenticated user endpoints
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/releases/{id}/status', [App\Http\Controllers\Api\Distribution\DistributionApiController::class, 'getReleaseStatus'])
            ->name('api.releases.status');
        
        Route::get('/earnings', [App\Http\Controllers\Api\Distribution\DistributionApiController::class, 'getEarnings'])
            ->name('api.earnings');
        
        Route::get('/payouts', [App\Http\Controllers\Api\Distribution\DistributionApiController::class, 'getPayouts'])
            ->name('api.payouts');
        
        Route::post('/payouts', [App\Http\Controllers\Api\Distribution\DistributionApiController::class, 'requestPayout'])
            ->middleware('throttle:10,1') // Limit payout requests to 10 per minute
            ->name('api.payouts.request');
    });
});