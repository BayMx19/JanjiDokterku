<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\RolesController;
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

    // Dashboard -> Semua Roles (tidak perlu cek role khusus)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('master')->group(function () {

        // Master Users -> Administrator
        Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':Administrator'])->group(function () {
            Route::get('/users', [UserController::class, 'index'])->name('users');
            Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/users', [UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

            // Master Pasien -> Administrator
            Route::get('/pasien', [PasienController::class, 'index'])->name('pasien');
            Route::get('/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
            Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
            Route::get('/pasien/{id}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
            Route::put('/pasien/{id}', [PasienController::class, 'update'])->name('pasien.update');
            Route::delete('/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');

            // Master Dokter -> Administrator
            Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');
            Route::get('/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
            Route::post('/dokter', [DokterController::class, 'store'])->name('dokter.store');
            Route::get('/dokter/{id}/edit', [DokterController::class, 'edit'])->name('dokter.edit');
            Route::put('/dokter/{id}', [DokterController::class, 'update'])->name('dokter.update');
            Route::delete('/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');
        });

        // Rekam Medis -> Dokter dan Administrator
        Route::middleware(['auth', \App\Http\Middleware\CheckRole::class . ':Administrator,Dokter'])->group(function () {
            Route::get('/rm', [RekamMedisController::class, 'index'])->name('rm');
            Route::get('/rm/create', [RekamMedisController::class, 'create'])->name('rm.create');
            Route::post('/rm', [RekamMedisController::class, 'store'])->name('rm.store');
            Route::get('/rm/{id}/edit', [RekamMedisController::class, 'edit'])->name('rm.edit');
            Route::put('/rm/{id}', [RekamMedisController::class, 'update'])->name('rm.update');
            Route::delete('/rm/{id}', [RekamMedisController::class, 'destroy'])->name('rm.destroy');
        });

        // Master Roles -> Semua Roles (cukup auth)
        Route::get('/roles', [RolesController::class, 'index'])->name('roles');
        Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
        Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
        Route::get('/roles/{id}/edit', [RolesController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RolesController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{id}', [RolesController::class, 'destroy'])->name('roles.destroy');
    });

    // Appointment -> Semua Roles (cukup auth)
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::get('/appointments/{id}/detail', [AppointmentController::class, 'detail'])->name('appointments.detail');
    Route::post('/appointments/{id}/rekam-medis', [AppointmentController::class, 'storeRekamMedis'])->name('appointments.storeRekamMedis');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

});require __DIR__.'/auth.php';
