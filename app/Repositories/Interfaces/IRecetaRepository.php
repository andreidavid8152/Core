<?php

namespace App\Repositories\Interfaces;

use App\Models\Receta;

interface IRecetaRepository
{
    public function findById(int $id): ?Receta;
}
