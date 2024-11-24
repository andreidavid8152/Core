<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;

class RecetaController extends Controller
{
    /**
     * Mostrar una receta pública específica.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Obtener la receta por ID junto con sus relaciones necesarias
        $receta = Receta::with('ingredientes')->findOrFail($id);

        // Pasar la receta a la vista
        return view('home.receta', compact('receta'));
    }
}
