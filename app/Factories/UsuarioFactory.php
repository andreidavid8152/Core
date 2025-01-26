<?php

namespace App\Factories;

use App\Models\Usuario;

class UsuarioFactory
{
    public static function crearDesdeSesion($sessionUsuario)
    {
        return Usuario::find($sessionUsuario->id);
    }
}
