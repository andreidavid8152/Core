<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use App\Models\Usuario;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener el usuario desde la sesión
        $usuario = session('usuario');

        // Obtener todas las recetas
        $recetas = Receta::where('usuario_id', '!=', $usuario->id)->get();

        // Pasar las recetas a la vista
        return view('home.index', compact('recetas'));
    }

    public function recomendaciones(){
        return view('home.recomendaciones');
    }

    public function favoritos()
    {
        // Obtener al usuario autenticado desde la sesión
        $usuario = session('usuario');
        $usuario = Usuario::find($usuario->id); // Asegurar el modelo completo

        // Obtener las recetas favoritas del usuario
        $favoritos = $usuario->recetasFavoritas;

        // Retornar la vista con las recetas favoritas
        return view('home.favoritos', compact('favoritos'));
    }


}
