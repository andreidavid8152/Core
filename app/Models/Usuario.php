<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $dispatchesEvents = [
        'updated' => \App\Events\UsuarioUpdated::class,
    ];
}
