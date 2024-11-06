<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingrediente;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredientes = Ingrediente::all();
        return view('admin.ingredientes.index', compact('ingredientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ingredientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:ingredientes,nombre'
        ]);

        Ingrediente::create($request->all());

        return redirect()->route('ingredientes.index')
        ->with('success', 'Ingrediente creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingrediente $ingrediente)
    {
        return view('admin.ingredientes.edit', compact('ingrediente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingrediente $ingrediente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:ingredientes,nombre,' . $ingrediente->id
        ]);

        $ingrediente->update($request->all());

        return redirect()->route('ingredientes.index')
        ->with('success', 'Ingrediente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingrediente $ingrediente)
    {
        // Verifica si el ingrediente está en uso en alguna receta
        if ($ingrediente->recetas()->exists()) {
            return redirect()->route('ingredientes.index')
            ->with('error', 'No se puede eliminar el ingrediente porque está en uso en una receta.');
        }

        // Si no está en uso, se permite la eliminación
        $ingrediente->delete();

        return redirect()->route('ingredientes.index')
        ->with('success', 'Ingrediente eliminado exitosamente');
    }
}
