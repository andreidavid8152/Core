<?php

namespace App\Http\Controllers;

use App\Factories\UsuarioFactory;
use App\Models\Receta;

class RecetaController extends Controller
{
    public function toggleFavorito($id)
    {
        $usuario = UsuarioFactory::crearDesdeSesion(session('usuario'));
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
