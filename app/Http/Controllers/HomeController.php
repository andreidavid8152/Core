<?php

namespace App\Http\Controllers;

use App\Services\RecetaService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $recetaService;

    public function __construct(RecetaService $recetaService)
    {
        $this->recetaService = $recetaService;
    }

    public function index()
    {
        $usuario = session('usuario');
        $recetas = $this->recetaService->obtenerRecetasNoDelUsuario($usuario);
        return view('home.index', compact('recetas'));
    }

    public function favoritos()
    {
        $usuario = session('usuario');
        $favoritos = $this->recetaService->obtenerRecetasFavoritas($usuario);
        return view('home.favoritos', compact('favoritos'));
    }
}
