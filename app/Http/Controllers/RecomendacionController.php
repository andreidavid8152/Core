<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Receta;
use Illuminate\Support\Facades\DB;

class RecomendacionController extends Controller
{
    public function index()
    {
        $usuario = session('usuario');
        $errores = [];

        // Verificar campos de la tabla usuarios
        if (!$usuario->altura) {
            $errores[] = 'Altura';
        }
        if (!$usuario->peso) {
            $errores[] = 'Peso';
        }
        if (!$usuario->sexo) {
            $errores[] = 'Sexo';
        }
        if (!$usuario->edad) {
            $errores[] = 'Edad';
        }
        if (!$usuario->caloriasPorComida) {
            $errores[] = 'Calorías por comida';
        }
        if (!$usuario->fechaRegistro) {
            $errores[] = 'Fecha de registro';
        }

        // Verificar registros mínimos en tablas pivote
        if ($usuario->preferencias()->count() < 3) {
            $errores[] = 'Al menos 3 preferencias';
        }
        if ($usuario->restricciones()->count() < 3) {
            $errores[] = 'Al menos 3 restricciones';
        }

        // Si hay errores, mostrar mensaje detallado
        if (count($errores) > 0) {
            return view('home.recomendaciones', [
                'mensaje' => 'Completa los siguientes datos en tu perfil para ver recomendaciones:',
                'errores' => $errores,
            ]);
        }

        // Obtener las preferencias y restricciones del usuario actual
        $preferenciasUsuario = $usuario->preferencias()->pluck('preferencias.id')->toArray();
        $restriccionesUsuario = $usuario->restricciones()->pluck('restricciones.id')->toArray();

        // Encontrar otros usuarios con preferencias y restricciones similares
        $usuariosSimilares = Usuario::where('id', '!=', $usuario->id)
            ->with(['preferencias', 'restricciones'])
            ->get();

        $usuariosSimilares = $usuariosSimilares->map(function ($u) use ($usuario, $preferenciasUsuario, $restriccionesUsuario) {

            $preferenciasCompartidas = count(array_intersect(
                $preferenciasUsuario,
                $u->preferencias->pluck('id')->toArray()
            ));
            $restriccionesCompartidas = count(array_intersect(
                $restriccionesUsuario,
                $u->restricciones->pluck('id')->toArray()
            ));

            $totalPreferencias = count($preferenciasUsuario);
            $totalRestricciones = count($restriccionesUsuario);

            $porcentajeCompatibilidad = 0;

            if ($totalPreferencias > 0) {
                $porcentajeCompatibilidad += ($preferenciasCompartidas / $totalPreferencias) * 50;
            }

            if ($totalRestricciones > 0) {
                $porcentajeCompatibilidad += ($restriccionesCompartidas / $totalRestricciones) * 50;
            }

            // Comparar datos personales (edad, sexo)
            $datosPersonalesCompatibles = 0;
            if ($u->sexo == $usuario->sexo) {
                $datosPersonalesCompatibles += 25;
            }
            if (abs($u->edad - $usuario->edad) <= 5) { // Edades similares si la diferencia es de 5 años o menos
                $datosPersonalesCompatibles += 25;
            }

            $porcentajeCompatibilidad += ($datosPersonalesCompatibles * 0.5); // Peso del 50% a los datos personales

            // Añadir el porcentaje de compatibilidad al usuario
            $u->porcentajeCompatibilidad = $porcentajeCompatibilidad;

            return $u;
        });

        // Filtrar usuarios con compatibilidad mayor al 50%
        $usuariosSimilares = $usuariosSimilares->filter(function ($u) {
            return $u->porcentajeCompatibilidad >= 50;
        });

        // Obtener recetas favoritas de los usuarios similares
        $recetasFavoritas = DB::table('receta_favorita')
        ->whereIn('usuario_id', $usuariosSimilares->pluck('id'))
        ->pluck('receta_id');

        // Obtener IDs de recetas favoritas del usuario actual para excluirlas
        $recetasFavoritasUsuarioActual = $usuario->recetasFavoritas()->pluck('recetas.id');

        // Excluir recetas que el usuario ya ha agregado a favoritos
        $recetasRecomendadas = Receta::whereIn('id', $recetasFavoritas)
            ->whereNotIn('id', $recetasFavoritasUsuarioActual)
            ->with('usuario')
            ->get();

        $recomendaciones = [];

        foreach ($recetasRecomendadas as $receta) {
            // Obtener el usuario que marcó como favorita la receta
            $usuarioReceta = $usuariosSimilares->firstWhere('id', $receta->usuario_id);

            if ($usuarioReceta) {
                // La compatibilidad de la receta es la misma que la del usuario que la marcó como favorita
                $porcentajeCompatibilidad = $usuarioReceta->porcentajeCompatibilidad;

                if ($porcentajeCompatibilidad >= 75) { // Considerar solo compatibilidad >= 75%
                    $recomendaciones[] = [
                        'receta' => $receta,
                        'compatibilidad' => round($porcentajeCompatibilidad, 2),
                    ];
                }
            }
        }

        // Ordenar las recomendaciones por mayor compatibilidad
        usort($recomendaciones, function ($a, $b) {
            return $b['compatibilidad'] <=> $a['compatibilidad'];
        });

        return view('home.recomendaciones', compact('recomendaciones'));
    }
}
