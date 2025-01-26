<?php

namespace App\Events;

use App\Models\Usuario;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UsuarioUpdated
{
    use Dispatchable, SerializesModels;

    public $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }
}
