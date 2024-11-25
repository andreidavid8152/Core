<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receta;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Ingrediente;

class MiRecetaController extends Controller
{
    public function index()
    {
        // Obtener el usuario desde la sesión
        $usuario = session('usuario');

        // Recuperar las recetas del usuario
        $recetas = Receta::where('usuario_id', $usuario->id)->get();

        return view('home.mis_recetas.index', compact('recetas'));
    }

    public function create()
    {
        $ingredientes = Ingrediente::all(); // Obtenemos todos los ingredientes de la base de datos
        return view('home.mis_recetas.create', compact('ingredientes'));
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
