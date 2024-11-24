<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MiRecetaController extends Controller
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
            'imagen' => 'nullable|image|mimes:svg,png,jpg,webp|max:2048',
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

        // Obtener el usuario desde la sesión
        $usuario = session('usuario');

        // Asegurarse de que el usuario exista en la sesión
        if (!$usuario) {
            return redirect()->route('login')->withErrors('Debe iniciar sesión para crear una receta.');
        }

        // Asignar el usuario_id
        $data['usuario_id'] = $usuario->id;

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
            'imagen' => 'nullable|image|mimes:svg,png,jpg,webp|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            if ($receta->imagen) {
                $publicId = basename($receta->imagen, '.' . pathinfo($receta->imagen, PATHINFO_EXTENSION));
                Cloudinary::destroy($publicId);
            }

            $file = $request->file('imagen');
            $uploadedFileUrl = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'recetas',
            ])->getSecurePath();

            $data['imagen'] = $uploadedFileUrl;
        }

        // Evitar que el usuario_id sea modificado
        $data['usuario_id'] = $receta->usuario_id;

        $receta->update($data);

        return redirect()->route('mis-recetas.index')->with('success', 'Receta actualizada exitosamente.');
    }



    public function destroy(Receta $receta)
    {
        $receta->delete();

        return redirect()->route('mis-recetas.index')->with('success', 'Receta eliminada exitosamente.');
    }
}
