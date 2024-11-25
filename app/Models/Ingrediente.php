<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $fillable = ['nombre'];

    // Relación muchos a muchos con Receta
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'receta_ingrediente')
        ->withPivot('cantidad', 'unidadMedida')
        ->withTimestamps();
    }
}
