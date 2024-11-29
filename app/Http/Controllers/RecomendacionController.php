<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // Placeholder para lógica de recomendaciones
        $recomendaciones = []; // Aquí irá la lógica más adelante

        return view('home.recomendaciones', compact('recomendaciones'));
    }

}
