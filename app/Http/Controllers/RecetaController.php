<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::all(); // Recupera todas las recetas
        return view('home.mis_recetas.index', compact('recetas'));
    }

    public function create()
    {
        return view('home.mis_recetas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');

            // Subir el archivo a Cloudinary
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'recetas',
            ])->getSecurePath();

            // Guardar la URL en el campo 'imagen'
            $data['imagen'] = $uploadedFileUrl;
        }

        Receta::create($data);

        return redirect()->route('mis-recetas.index')->with('success', 'Receta creada exitosamente.');
    }

    public function edit(Receta $receta)
    {
        return view('home.mis_recetas.edit', compact('receta'));
    }

    public function update(Request $request, Receta $receta)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior de Cloudinary
            if ($receta->imagen) {
                // Obtener el public_id de la imagen anterior
                $publicId = basename($receta->imagen, '.' . pathinfo($receta->imagen, PATHINFO_EXTENSION));

                // Eliminar la imagen
                Cloudinary::destroy($publicId);
            }

            $file = $request->file('imagen');

            // Subir el archivo a Cloudinary
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'recetas',
            ])->getSecurePath();

            // Guardar la URL en el campo 'imagen'
            $data['imagen'] = $uploadedFileUrl;
        }

        $receta->update($data);

        return redirect()->route('mis-recetas.index')->with('success', 'Receta actualizada exitosamente.');
    }


    public function destroy(Receta $receta)
    {
        $receta->delete();

        return redirect()->route('mis-recetas.index')->with('success', 'Receta eliminada exitosamente.');
    }
}
