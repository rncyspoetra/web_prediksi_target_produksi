<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataHistorisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RegresiLinearController;
use App\Http\Controllers\PrediksiTargetController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // DATA HISTORIS
    Route::prefix('data-historis')->group(function () {
        Route::get('/', [DataHistorisController::class, 'index'])->name('data-historis.index');
        Route::get('/create', [DataHistorisController::class, 'create'])->name('data-historis.create');
        Route::post('/', [DataHistorisController::class, 'store'])->name('data-historis.store');

        Route::get('/{id}/edit', [DataHistorisController::class, 'edit'])->name('data-historis.edit');
        Route::put('/{id}', [DataHistorisController::class, 'update'])->name('data-historis.update');

        Route::delete('/{id}', [DataHistorisController::class, 'destroy'])->name('data-historis.destroy');

        Route::get('/export', [DataHistorisController::class, 'export'])
            ->name('data-historis.export');

        Route::post(
            '/import',
            [DataHistorisController::class, 'import']
        )->name('data-historis.import');
    });

    // USER
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');

        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update');

        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Reset Password
        Route::put('/{id}/reset-password', [UserController::class, 'resetPassword'])
            ->name('user.reset-password');
    });

    // PROSES PREDIKSI REGRESI
    Route::prefix('proses-prediksi')->group(function () {

        Route::get('/', [RegresiLinearController::class, 'index'])
            ->name('proses-prediksi.index');

        Route::post('/generate', [RegresiLinearController::class, 'generate'])
            ->name('proses-prediksi.generate');

        Route::get('/export', [RegresiLinearController::class, 'export'])
            ->name('proses-prediksi.export');
    });

    // PROSES PREDIKSI TARGET PRODUKSI
    Route::prefix('prediksi-target')->group(function () {

        Route::get('/', [PrediksiTargetController::class, 'index'])
            ->name('prediksi-target.index');

        Route::post('/', [PrediksiTargetController::class, 'store'])
            ->name('prediksi-target.store');

        Route::delete('/{prediksitarget}', [PrediksiTargetController::class, 'destroy'])
            ->name('prediksi-target.destroy');
    });

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password.update');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

require __DIR__ . '/auth.php';
