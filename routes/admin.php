<?php

use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', [AdminTaskController::class, 'index']);
        Route::get('/{task}', [AdminTaskController::class, 'show']);
        Route::post('/', [AdminTaskController::class, 'store']);
        Route::put('/{task}', [AdminTaskController::class, 'update']);
        Route::put('/{task}/status', [AdminTaskController::class, 'updateTaskStatus']);
        // Dependencies management
        Route::get('/{task}/dependencies', [AdminTaskController::class, 'getTaskDependencies']);
        Route::post('/{task}/dependencies', [AdminTaskController::class, 'addTaskDependencies']);
        Route::delete('/{task}/dependencies/{dependency}', [AdminTaskController::class, 'removeTaskDependency']);

    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
