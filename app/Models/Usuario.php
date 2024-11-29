<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps = false;
    protected $fillable = ['nombre', 'email', 'contrasena', 'peso', 'altura', 'sexo', 'edad', 'caloriasPorComida'];

    public function recetas()
    {
        return $this->hasMany(Receta::class, 'usuario_id');
    }

    public function restricciones()
    {
        return $this->belongsToMany(Restriccion::class, 'restriccion_usuario','usuario_id', 'restriccion_id')->withTimestamps();
    }

    public function preferencias()
    {
        return $this->belongsToMany(Preferencia::class, 'preferencia_usuario', 'usuario_id', 'preferencia_id')->withTimestamps();
    }

    public function recetasFavoritas()
    {
        return $this->belongsToMany(Receta::class, 'receta_favorita', 'usuario_id', 'receta_id')->withTimestamps();
    }

}
