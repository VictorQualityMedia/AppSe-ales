<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SenalesController;
use App\Http\Controllers\PruebasController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --------------------------- Rutas Senal ---------------------------

Route::get('/senales', [SenalesController::class, 'senales'])->name('senales');

Route::post('/registrar_senal', [SenalesController::class, 'registrar_senal'])->name('registrar_senal');

Route::post('/guardar_senal/{id}', [SenalesController::class, 'guardar_senal'])->name('guardar_senal');

// --------------------------- Rutas Prueba ---------------------------

Route::get('/pruebas', [PruebasController::class, 'pruebas'])->name('pruebas');

Route::post('/registrar_prueba', [PruebasController::class, 'registrar_prueba'])->name('registrar_prueba');

Route::post('/guardar_prueba/{id}', [PruebasController::class, 'guardar_prueba'])->name('guardar_prueba');