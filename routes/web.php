<?php

use App\Http\Controllers\ChemicAnalyticController;
use App\Http\Controllers\LakeController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FluidManagmentController;
use App\Http\Controllers\WaterDosagesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [
    LakeController::class, 'index',
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
])->name('lake.index');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('chemic-analytics', ChemicAnalyticController::class);
    Route::resource('lakes', LakeController::class);
    Route::resource('monitoring', MonitoringController::class);
    Route::resource('fluid-management', FluidManagmentController::class);

});

require __DIR__ . '/auth.php';
