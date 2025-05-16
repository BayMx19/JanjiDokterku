<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('master')->group(function () {
        Route::inertia('/users', 'User/Index');
        Route::inertia('/users/create', 'User/Create');
        Route::inertia('/users/{id}/edit', 'User/Edit');

        Route::inertia('/pasien', 'Pasien/Index');
        Route::inertia('/pasien/create', 'Pasien/Create');
        Route::inertia('/pasien/{id}/edit', 'Pasien/Edit');

        Route::inertia('/dokter', 'Dokter/Index');
        Route::inertia('/dokter/create', 'Dokter/Create');
        Route::inertia('/dokter/{id}/edit', 'Dokter/Edit');

        Route::inertia('/roles', 'Role/Index');
        Route::inertia('/roles/create', 'Role/Create');
        Route::inertia('/roles/{id}/edit', 'Role/Edit');
    });

    Route::prefix('appointment')->group(function () {
        Route::inertia('/', 'Appointment/Index');
        Route::inertia('/create', 'Appointment/Create');
        Route::inertia('/{id}/edit', 'Appointment/Edit');
    });
});

require __DIR__.'/auth.php';
