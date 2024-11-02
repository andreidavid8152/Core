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
        return view('restricciones.index', compact('restricciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restricciones.create');    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required'
        ]);

        Restriccion::create($request->all());
        return redirect()->route('restricciones.index')
                ->with('success', 'Restricción creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restriccion $restriccion)
    {
        return view('restricciones.edit', compact('restriccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restriccion $restriccion)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
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
        $restriccion->delete();
        return redirect()->route('restricciones.index')
        ->with('success', 'Restricción eliminada exitosamente');
    }
}
