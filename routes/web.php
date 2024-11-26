<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestriccionController;
use App\Http\Controllers\PreferenciaController;
use App\Http\Controllers\IngredienteController;
use App\Http\Controllers\MiRecetaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\PerfilController;

Route::get('/', function () {
    return view('welcome');
});

// Usuarios
Route::middleware(['user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/recomendaciones', [HomeController::class, 'recomendaciones'])->name('recomendaciones');
    Route::get('/favoritos', [HomeController::class, 'favoritos'])->name('favoritos');

    Route::resource('mis-recetas', MiRecetaController::class)
    ->parameters([
        'mis-recetas' => 'receta',
    ]);

    Route::get('/recetas/{id}', [RecetaController::class, 'show'])->name('recetas.show');

    Route::post('/recetas/{id}/favorito', [RecetaController::class, 'toggleFavorito'])->name('recetas.favorito');

    Route::resource('perfil', PerfilController::class)->only(['index', 'update'])->names([
        'index' => 'perfil',
    ]);

});

// Administrador
Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::resource('restricciones', RestriccionController::class)->parameters([
        'restricciones' => 'restriccion'
    ]);

    Route::resource('preferencias', PreferenciaController::class)->parameters([
        'preferencias' => 'preferencia'
    ]);

    Route::resource('ingredientes', IngredienteController::class)->parameters([
        'ingredientes' => 'ingrediente'
    ]);

});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
