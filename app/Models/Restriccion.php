<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restriccion extends Model
{

    // Nombre de la tabla en la base de datos
    protected $table = 'restricciones';

    // Campos que pueden ser rellenados mediante un array
    protected $fillable = [
        'descripcion',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'restriccion_usuario','restriccion_id', 'usuario_id')->withTimestamps();
    }

}
