<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestriccionController;

Route::get('/', function () {
    return view('welcome');
});

// Usuarios
Route::middleware(['user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/recomendaciones', [HomeController::class, 'recomendaciones'])->name('recomendaciones');
    Route::get('/favoritos', [HomeController::class, 'favoritos'])->name('favoritos');
});

// Administrador
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('restricciones', RestriccionController::class)->parameters([
        'restricciones' => 'restriccion'
    ]);

});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
