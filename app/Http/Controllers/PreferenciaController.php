<?php

namespace App\Http\Controllers;

use App\Models\Preferencia;
use Illuminate\Http\Request;

class PreferenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preferencias = Preferencia::all();
        return view('admin.preferencias.index', compact('preferencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.preferencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:preferencias,descripcion'
        ]);

        Preferencia::create($request->all());

        return redirect()->route('preferencias.index')
        ->with('success', 'Preferencia creada exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preferencia $preferencia)
    {
        return view('admin.preferencias.edit', compact('preferencia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preferencia $preferencia)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255|unique:preferencias,descripcion,' . $preferencia->id,
        ]);

        $preferencia->update($request->all());

        return redirect()->route('preferencias.index')
        ->with('success', 'Preferencia actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preferencia $preferencia)
    {
        // Verifica si la preferencia está en uso por algún usuario
        if ($preferencia->usuarios()->exists()) {
            return redirect()->route('preferencias.index')
            ->with('error', 'No se puede eliminar la preferencia porque está en uso.');
        }

        // Si no está en uso, se permite la eliminación
        $preferencia->delete();

        return redirect()->route('preferencias.index')
        ->with('success', 'Preferencia eliminada exitosamente');
    }
}
