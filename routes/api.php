<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('integrations')
    ->middleware(['auth-api'])
    ->group(function (): void {
        Route::get('/', function () {
            return response()->json(['message' => 'Integrations API is working']);
        });
    });


Route::middleware(['guest.check'])
    ->group(function (): void {
        Route::post('/authenticate', [AuthController::class, 'authenticate']);
    });

Route::prefix('user')
    ->middleware(['jwt'])
    ->group(function (): void {
        Route::get('/', [AuthController::class, 'getUser']);
    });
