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
        Route::inertia('/users', 'Users/Index')->name('users');
    Route::inertia('/users/create', 'Users/Create')->name('users.create');
    Route::inertia('/users/{id}/edit', 'Users/Edit')->name('users.edit');

    Route::inertia('/pasien', 'Pasien/Index')->name('pasien');
    Route::inertia('/pasien/create', 'Pasien/Create')->name('pasien.create');
    Route::inertia('/pasien/{id}/edit', 'Pasien/Edit')->name('pasien.edit');

    Route::inertia('/dokter', 'Dokter/Index')->name('dokter');
    Route::inertia('/dokter/create', 'Dokter/Create')->name('dokter.create');
    Route::inertia('/dokter/{id}/edit', 'Dokter/Edit')->name('dokter.edit');

    Route::inertia('/roles', 'Roles/Index')->name('roles');
    Route::inertia('/roles/create', 'Roles/Create')->name('roles.create');
    Route::inertia('/roles/{id}/edit', 'Roles/Edit')->name('roles.edit');
    });

    Route::inertia('/appointment', 'Appointments/Index')->name('appointment');
    Route::inertia('/appointment/create', 'Appointments/Create')->name('appointment.create');
    Route::inertia('/appointment/{id}/edit', 'Appointments/Edit')->name('appointment.edit');
});

require __DIR__.'/auth.php';
