<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
    protected $fillable = ['nombre', 'email', 'contrasena', 'peso', 'altura', 'sexo', 'edad', 'caloriasPorComida'];

    public function restricciones()
    {
        return $this->belongsToMany(Restriccion::class, 'restriccion_usuario');
    }

    public function preferencias()
    {
        return $this->belongsToMany(Preferencia::class, 'preferencia_usuario');
    }


}
