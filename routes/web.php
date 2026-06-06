<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Student\ProjectController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Supervisor\ProjectController as SupervisorProjectController;
use App\Http\Controllers\Supervisor\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Auth routes (provided by Breeze)
require __DIR__.'/auth.php';

// Student routes
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');

        // Project routes
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/submit', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{project}/download', [ProjectController::class, 'download'])->name('projects.download');
    });

// Supervisor routes
Route::middleware(['auth', 'role:supervisor'])
    ->prefix('supervisor')
    ->name('supervisor.')
    ->group(function () {
        Route::get('/dashboard', [SupervisorController::class, 'dashboard'])->name('dashboard');

        // Project review routes
        Route::get('/projects', [SupervisorProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [SupervisorProjectController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/approve', [SupervisorProjectController::class, 'approve'])->name('projects.approve');
        Route::post('/projects/{project}/reject', [SupervisorProjectController::class, 'reject'])->name('projects.reject');
        Route::post('/projects/{project}/comment', [SupervisorProjectController::class, 'comment'])->name('projects.comment');
        Route::post('/projects/{project}/revert', [SupervisorProjectController::class, 'revert'])->name('projects.revert');
    });

// Admin routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
