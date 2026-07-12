<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\PomodoroSessionController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('pomodoro-sessions', PomodoroSessionController::class);
});

Route::get('/status', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API is working'
    ]);
});
