<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restriccion;

class RestriccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restricciones = Restriccion::all();
        return view('admin.restricciones.index', compact('restricciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.restricciones.create');    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:restricciones,descripcion'
        ]);

        Restriccion::create($request->all());
        return redirect()->route('restricciones.index')
                ->with('success', 'Restricción creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restriccion $restriccion)
    {
        return view('admin.restricciones.edit', compact('restriccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restriccion $restriccion)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:restricciones,descripcion,' . $restriccion->id
        ]);

        $restriccion->update($request->all());
        return redirect()->route('restricciones.index')
        ->with('success', 'Restricción actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restriccion $restriccion)
    {
        // Verifica si la restricción está en uso por algún usuario
        if ($restriccion->usuarios()->exists()) {
            return redirect()->route('restricciones.index')
            ->with('error', 'No se puede eliminar la restricción porque está en uso.');
        }

        // Si no está en uso, se permite la eliminación
        $restriccion->delete();

        return redirect()->route('restricciones.index')
        ->with('success', 'Restricción eliminada exitosamente');
    }
}
