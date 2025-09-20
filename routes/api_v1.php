<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserTaskController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::prefix('tasks')->group(function () {
        // Users can only retrieve tasks assigned to them
        Route::get('/', [UserTaskController::class, 'index']);
        Route::get('/{task}', [UserTaskController::class, 'show']);

        // Users can only update status of tasks assigned to them
        Route::put('/{task}/status', [UserTaskController::class, 'updateTaskStatus']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
