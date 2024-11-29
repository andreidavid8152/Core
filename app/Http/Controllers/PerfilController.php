<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Restriccion;
use App\Models\Preferencia;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = Usuario::with(['restricciones', 'preferencias'])->find(session('usuario')->id);

        $restricciones = Restriccion::all();
        $restriccionesUsuario = $usuario->restricciones->pluck('id')->toArray();

        $preferencias = Preferencia::all();
        $preferenciasUsuario = $usuario->preferencias->pluck('id')->toArray();

        return view('perfil', compact('usuario', 'restricciones', 'restriccionesUsuario', 'preferencias', 'preferenciasUsuario'));
    }

    public function update(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'nombre' => 'required|string|max:100',
            'peso' => 'required|numeric|min:0|max:635',
            'altura' => 'required|numeric|min:0|max:3',
            'edad' => 'required|integer|min:0|max:120',
            'sexo' => 'required|string|in:Masculino,Femenino',
            'caloriasPorComida' => 'required|integer|min:0|max:9999',
        ]);

        $usuario->update($request->only('nombre', 'peso', 'altura', 'edad', 'sexo', 'caloriasPorComida'));

        session(['usuario' => $usuario]); // Actualizamos la sesión

        return redirect()->route('perfil')->with('success', 'Información actualizada exitosamente.');
    }

    public function updateRestricciones(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Validar las restricciones
        $request->validate([
            'restricciones' => 'array|exists:restricciones,id',
        ]);

        // Actualizar las restricciones del usuario
        $usuario->restricciones()->sync($request->input('restricciones', []));

        // Recuperar las restricciones actualizadas, especificando la tabla para evitar ambigüedad
        $restricciones = $usuario->restricciones()->get(['restricciones.id', 'restricciones.descripcion']);

        // Devolver respuesta JSON
        return response()->json([
            'success' => true,
            'restricciones' => $restricciones,
        ]);
    }

    public function updatePreferencias(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'preferencias' => 'array|exists:preferencias,id',
        ]);

        $usuario->preferencias()->sync($request->input('preferencias', []));

        $preferencias = $usuario->preferencias()->get(['preferencias.id', 'preferencias.descripcion']);

        return response()->json([
            'success' => true,
            'preferencias' => $preferencias,
        ]);
    }

}
