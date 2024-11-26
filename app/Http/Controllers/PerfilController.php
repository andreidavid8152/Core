<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = session('usuario'); // Obtenemos el usuario desde la sesión
        return view('perfil', compact('usuario'));
    }

    public function update(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'nombre' => 'required|string|max:100',
            'peso' => 'nullable|numeric|min:0|max:999.99',
            'altura' => 'nullable|numeric|min:0|max:99.99',
            'edad' => 'nullable|integer|min:0|max:120',
            'sexo' => 'nullable|string|in:Masculino,Femenino',
            'caloriasPorComida' => 'nullable|integer|min:0|max:9999',
        ]);

        $usuario->update($request->only('nombre', 'peso', 'altura', 'edad', 'sexo', 'caloriasPorComida'));

        session(['usuario' => $usuario]); // Actualizamos la sesión

        return redirect()->route('perfil')->with('success', 'Información actualizada exitosamente.');
    }
}
