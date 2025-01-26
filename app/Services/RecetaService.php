<?php

namespace App\Services;

use App\Models\Receta;
use App\Models\Usuario;

class RecetaService
{
    public function obtenerRecetasNoDelUsuario(Usuario $usuario)
    {
        return Receta::where('usuario_id', '!=', $usuario->id)->get();
    }

    public function obtenerRecetasFavoritas(Usuario $usuario)
    {
        return $usuario->recetasFavoritas;
    }
}
