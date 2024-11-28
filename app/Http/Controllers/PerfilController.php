<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Restriccion;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = Usuario::with('restricciones')->find(session('usuario')->id); // Carga las restricciones del usuario
        $restricciones = Restriccion::all(); // Todas las restricciones disponibles
        $restriccionesUsuario = $usuario->restricciones->pluck('id')->toArray(); // IDs de restricciones del usuario

        return view('perfil', compact('usuario', 'restricciones', 'restriccionesUsuario'));
    }

    public function update(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'nombre' => 'required|string|max:100',
            'peso' => 'nullable|numeric|min:0|max:635',
            'altura' => 'nullable|numeric|min:0|max:3',
            'edad' => 'nullable|integer|min:0|max:120',
            'sexo' => 'nullable|string|in:Masculino,Femenino',
            'caloriasPorComida' => 'nullable|integer|min:0|max:9999',
        ]);

        $usuario->update($request->only('nombre', 'peso', 'altura', 'edad', 'sexo', 'caloriasPorComida'));

        session(['usuario' => $usuario]); // Actualizamos la sesión

        return redirect()->route('perfil')->with('success', 'Información actualizada exitosamente.');
    }

    public function updateRestricciones(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id); // Busca al usuario por ID

        // Validar las restricciones
        $request->validate([
            'restricciones' => 'array|exists:restricciones,id', // Validar que las restricciones sean válidas
        ]);

        // Actualizar las restricciones del usuario
        $usuario->restricciones()->sync($request->input('restricciones', [])); // Sincroniza las restricciones seleccionadas

        return redirect()->route('perfil')->with('success', 'Restricciones actualizadas exitosamente.');
    }

}
