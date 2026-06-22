<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\RepositoryController;
use App\Http\Controllers\Student\ProjectController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Supervisor\ProjectController as SupervisorProjectController;
use App\Http\Controllers\Supervisor\SupervisorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }

    return view('welcome');
});

// ── Public repository (no login required) ─────────────────────
Route::get('/explore', [RepositoryController::class, 'publicIndex'])->name('public.repository');
Route::get('/explore/{project}', [RepositoryController::class, 'publicShow'])->name('public.repository.show');

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

// ─── Repository (all authenticated users) ─────────────────────
Route::middleware(['auth'])
    ->prefix('repository')
    ->name('repository.')
    ->group(function () {
        Route::get('/', [RepositoryController::class, 'index'])->name('index');
        Route::get('/{project}', [RepositoryController::class, 'show'])->name('show');
        Route::get('/{project}/download', [RepositoryController::class, 'download'])->name('download');
    });

// Admin routes
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // User management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Project management
        Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [AdminProjectController::class, 'show'])->name('projects.show');
        Route::post('/projects/{project}/approve', [AdminProjectController::class, 'approve'])->name('projects.approve');
        Route::post('/projects/{project}/reject', [AdminProjectController::class, 'reject'])->name('projects.reject');
        Route::post('/projects/{project}/supervisor', [AdminProjectController::class, 'assignSupervisor'])->name('projects.supervisor');
        Route::delete('/projects/{project}', [AdminProjectController::class, 'destroy'])->name('projects.destroy');
        Route::get('/projects/{project}/download', [AdminProjectController::class, 'download'])->name('projects.download');

        // Activity log
        Route::get('/activity', [AdminProjectController::class, 'activityLog'])->name('activity');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    });

// Shared: any authenticated user can download approved project PDFs
Route::middleware(['auth'])
    ->group(function () {
        Route::get('/projects/{project}/download',
            [ProjectController::class, 'download'])
            ->name('projects.download');
    });
