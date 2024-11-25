<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use App\Models\Usuario;

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

    public function toggleFavorito($id)
    {
        $usuario = session('usuario'); // Usuario autenticado
        $usuario = Usuario::find($usuario->id);
        $receta = Receta::findOrFail($id);

        if ($usuario->recetasFavoritas()->where('receta_id', $receta->id)->exists()) {
            $usuario->recetasFavoritas()->detach($receta->id);
            return redirect()->route('recetas.show', $id)->with('success', 'Receta removida de favoritos.');
        } else {
            $usuario->recetasFavoritas()->attach($receta->id);
            return redirect()->route('recetas.show', $id)->with('success', 'Receta agregada a favoritos.');
        }
    }

}
