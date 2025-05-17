<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
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
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::prefix('master')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/master/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/master/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien');
    Route::get('/master/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/master/pasien', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');


    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');
    Route::get('/master/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
    Route::post('/master/dokter', [DokterController::class, 'store'])->name('dokter.store');
    Route::get('/dokter/{id}/edit', [DokterController::class, 'edit'])->name('dokter.edit');
    Route::put('/dokter/{id}', [DokterController::class, 'update'])->name('dokter.update');
    Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');

    Route::inertia('/roles', 'Roles/Index')->name('roles');
    Route::inertia('/roles/create', 'Roles/Create')->name('roles.create');
    Route::inertia('/roles/{id}/edit', 'Roles/Edit')->name('roles.edit');
    });

    Route::inertia('/appointment', 'Appointments/Index')->name('appointment');
    Route::inertia('/appointment/create', 'Appointments/Create')->name('appointment.create');
    Route::inertia('/appointment/{id}/edit', 'Appointments/Edit')->name('appointment.edit');
});

require __DIR__.'/auth.php';
