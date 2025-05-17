<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/master/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/master/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


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
