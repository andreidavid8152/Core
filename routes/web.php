<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('authMiddleware')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/recomendaciones', [HomeController::class, 'recomendaciones'])->name('recomendaciones');
    Route::get('/favoritos', [HomeController::class, 'favoritos'])->name('favoritos');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
