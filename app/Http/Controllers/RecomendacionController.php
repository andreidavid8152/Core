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

        // Validar el perfil del usuario
        $errores = $this->validarPerfilUsuario($usuario);

        // Si hay errores, mostrar mensaje detallado
        if (count($errores) > 0) {
            return view('home.recomendaciones', [
                'mensaje' => 'Completa los siguientes datos en tu perfil para ver recomendaciones:',
                'errores' => $errores,
            ]);
        }

        // Obtener usuarios similares
        $usuariosSimilares = $this->obtenerUsuariosSimilares($usuario);

        // Obtener recomendaciones de recetas
        $recomendaciones = $this->obtenerRecomendaciones($usuario, $usuariosSimilares);

        return view('home.recomendaciones', compact('recomendaciones'));
    }

    /**
     * Validar que el perfil del usuario esté completo.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return array  $errores
     */
    private function validarPerfilUsuario($usuario)
    {
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

        return $errores;
    }

    /**
     * Obtener usuarios similares basados en preferencias, restricciones y datos personales.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Support\Collection  $usuariosSimilares
     */
    private function obtenerUsuariosSimilares($usuario)
    {
        // Obtener las preferencias y restricciones del usuario actual
        $preferenciasUsuario = $usuario->preferencias()->pluck('preferencias.id')->toArray();
        $restriccionesUsuario = $usuario->restricciones()->pluck('restricciones.id')->toArray();

        // Obtener otros usuarios con sus preferencias y restricciones
        $otrosUsuarios = Usuario::where('id', '!=', $usuario->id)
            ->with(['preferencias', 'restricciones'])
            ->get();

        // Calcular compatibilidad para cada usuario
        $usuariosSimilares = $otrosUsuarios->map(function ($u) use ($usuario, $preferenciasUsuario, $restriccionesUsuario) {
            $u->porcentajeCompatibilidad = $this->calcularCompatibilidad($usuario, $u, $preferenciasUsuario, $restriccionesUsuario);
            return $u;
        });

        // Filtrar usuarios con compatibilidad mayor o igual al 50%
        $usuariosSimilares = $usuariosSimilares->filter(function ($u) {
            return $u->porcentajeCompatibilidad >= 50;
        });

        return $usuariosSimilares;
    }

    /**
     * Calcular el porcentaje de compatibilidad entre dos usuarios.
     *
     * @param  \App\Models\Usuario  $usuarioActual
     * @param  \App\Models\Usuario  $otroUsuario
     * @param  array  $preferenciasUsuario
     * @param  array  $restriccionesUsuario
     * @return float  $porcentajeCompatibilidad
     */
    private function calcularCompatibilidad($usuarioActual, $otroUsuario, $preferenciasUsuario, $restriccionesUsuario)
    {
        $preferenciasCompartidas = count(array_intersect(
            $preferenciasUsuario,
            $otroUsuario->preferencias->pluck('id')->toArray()
        ));
        $restriccionesCompartidas = count(array_intersect(
            $restriccionesUsuario,
            $otroUsuario->restricciones->pluck('id')->toArray()
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
        if ($otroUsuario->sexo == $usuarioActual->sexo) {
            $datosPersonalesCompatibles += 25;
        }
        if (abs($otroUsuario->edad - $usuarioActual->edad) <= 5) { // Edades similares si la diferencia es de 5 años o menos
            $datosPersonalesCompatibles += 25;
        }

        $porcentajeCompatibilidad += ($datosPersonalesCompatibles * 0.5); // Peso del 50% a los datos personales

        return $porcentajeCompatibilidad;
    }

    /**
     * Obtener recomendaciones de recetas basadas en usuarios similares.
     *
     * @param  \App\Models\Usuario  $usuario
     * @param  \Illuminate\Support\Collection  $usuariosSimilares
     * @return array  $recomendaciones
     */
    private function obtenerRecomendaciones($usuario, $usuariosSimilares)
    {
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

        return $recomendaciones;
    }
}
