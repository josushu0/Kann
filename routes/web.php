<?php

use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/projects');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::redirect('/dashboard', '/projects');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('projects', ProjectController::class);

    Route::resource('columns', ColumnController::class)->only('store', 'update', 'destroy');
    Route::put('/columns/{column}/move', [ColumnController::class, 'move'])->name('columns.move');

    Route::resource('tasks', TaskController::class)->only('store', 'update', 'destroy');
    Route::put('/tasks/{task}/move', [TaskController::class, 'move'])->name('tasks.move');
});
