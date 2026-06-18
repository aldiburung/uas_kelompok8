<?php

use App\Http\Controllers\BarterController;
use App\Http\Controllers\BarterRequestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TerminController;
use Illuminate\Support\Facades\Route;

// Route model binding
Route::model('barter', \App\Models\Commodity::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('keuangan', KeuanganController::class)->except(['show']);
    Route::resource('termins', TerminController::class)->except(['show']);
    Route::resource('reports', ReportController::class)->only(['index']);
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::resource('barter', BarterController::class);
    Route::resource('barter-requests', BarterRequestController::class)->except(['show', 'edit', 'update']);
});

require __DIR__.'/auth.php';
