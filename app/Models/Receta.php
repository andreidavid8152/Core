<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'pasosPreparacion', 'caloriasConsumidas', 'usuario_id'];

    // Relación muchos a muchos con Ingrediente
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'receta_ingrediente')
            ->withPivot('cantidad', 'unidadMedida');
    }
}
