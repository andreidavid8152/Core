<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'pasosPreparacion', 'caloriasConsumidas', 'usuario_id', 'imagen'];

    // Relación muchos a muchos con Ingrediente
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'receta_ingrediente')
            ->withPivot('cantidad', 'unidadMedida')
            ->withTimestamps();
    }

    public function usuariosFavoritos()
    {
        return $this->belongsToMany(Usuario::class, 'receta_favorita', 'receta_id', 'usuario_id')->withTimestamps();
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
