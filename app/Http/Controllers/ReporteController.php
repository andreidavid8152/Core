<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        $similitudes = $this->obtenerRecetasSimilaresYFavoritas();

        return view('home.reporte', compact('similitudes'));
    }

    private function obtenerRecetasSimilaresYFavoritas()
    {
        // Obtener todas las recetas con sus ingredientes y conteo de favoritos
        $recetas = Receta::with(['ingredientes', 'usuariosFavoritos'])
            ->withCount('usuariosFavoritos')
            ->get();

        $similitudes = [];

        $recetaCount = count($recetas);
        for ($i = 0; $i < $recetaCount; $i++) {
            for ($j = $i + 1; $j < $recetaCount; $j++) {
                $recetaA = $recetas[$i];
                $recetaB = $recetas[$j];

                // Calcular la similitud basada en ingredientes compartidos
                $ingredientesA = $recetaA->ingredientes->pluck('id')->toArray();
                $ingredientesB = $recetaB->ingredientes->pluck('id')->toArray();

                $ingredientesCompartidos = count(array_intersect($ingredientesA, $ingredientesB));

                if ($ingredientesCompartidos > 0) {
                    $totalIngredientes = count(array_unique(array_merge($ingredientesA, $ingredientesB)));
                    $porcentajeSimilitud = ($ingredientesCompartidos / $totalIngredientes) * 100;

                    // Obtener el conteo de favoritos de ambas recetas
                    $favoritosRecetaA = $recetaA->usuarios_favoritos_count;
                    $favoritosRecetaB = $recetaB->usuarios_favoritos_count;

                    // Sumar los favoritos de ambas recetas
                    $totalFavoritos = $favoritosRecetaA + $favoritosRecetaB;

                    $similitudes[] = [
                        'receta_a' => $recetaA,
                        'receta_b' => $recetaB,
                        'similitud' => round($porcentajeSimilitud, 2),
                        'total_favoritos' => $totalFavoritos,
                    ];
                }
            }
        }

        usort($similitudes, function ($a, $b) {
            if ($b['total_favoritos'] === $a['total_favoritos']) {
                return $b['similitud'] <=> $a['similitud'];
            }
            return $b['total_favoritos'] <=> $a['total_favoritos'];
        });

        $similitudes = array_slice($similitudes, 0, 10);

        return $similitudes;
    }
}
