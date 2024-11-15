<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;

class HomeController extends Controller
{
    public function index()
    {
        // Obtener todas las recetas
        $recetas = Receta::all();

        // Pasar las recetas a la vista
        return view('home.index', compact('recetas'));
    }

    public function recomendaciones(){
        return view('home.recomendaciones');
    }

    public function favoritos(){
        return view('home.favoritos');
    }

}
