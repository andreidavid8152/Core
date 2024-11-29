<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{

    protected $fillable = ['descripcion'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'preferencia_usuario', 'usuario_id', 'preferencia_id')->withTimestamps();
    }

}
