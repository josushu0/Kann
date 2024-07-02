<?php

use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [ProjectController::class, 'index'])->name('projects.index');

    Route::resource('projects', ProjectController::class)->except('index');

    Route::resource('columns', ColumnController::class)->only('store', 'update', 'destroy');
    Route::put('/columns/{column}/move', [ColumnController::class, 'move'])->name('columns.move');

    Route::resource('tasks', TaskController::class)->only('store', 'update', 'destroy');
    Route::put('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
});
