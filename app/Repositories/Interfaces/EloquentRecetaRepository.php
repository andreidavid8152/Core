<?php

namespace App\Repositories;

use App\Models\Receta;
use App\Repositories\Interfaces\IRecetaRepository;

class EloquentRecetaRepository implements IRecetaRepository
{
    public function findById(int $id): ?Receta
    {
        return Receta::find($id);
    }
}
