<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest.check'])
    ->group(function (): void {
        Route::post('/authenticate', [AuthController::class, 'authenticate']);
    });

Route::middleware(['jwt'])
    ->group(function (): void {
        Route::get('/user', [AuthController::class, 'getUser']);
    });
