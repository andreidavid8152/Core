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
            'pasosPreparacion' => 'required|string',
            'caloriasConsumidas' => 'required|integer|min:0',
            'imagen' => 'required|image|mimes:svg,png,jpg,webp|max:2048',
            'ingredientes' => 'required|array',
            'ingredientes.*.id' => 'required|integer|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|integer|min:1',
            'ingredientes.*.unidadMedida' => 'required|string|max:50', 
        ]);

        $data = $request->except('ingredientes');

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

        // Crear la receta
        $receta = Receta::create($data);

        // Asociar ingredientes a la receta con cantidades y unidades
        foreach ($request->input('ingredientes') as $ingredienteData) {
            $receta->ingredientes()->attach($ingredienteData['id'], [
                'cantidad' => $ingredienteData['cantidad'],
                'unidadMedida' => $ingredienteData['unidadMedida'], // Cambiado a 'unidadMedida'
            ]);
        }

        return redirect()->route('mis-recetas.index')->with('success', 'Receta creada exitosamente.');
    }


    public function edit(Receta $receta)
    {
        $ingredientes = Ingrediente::all();
        $ingredientesSeleccionados = $receta->ingredientes()->withPivot('cantidad', 'unidadMedida')->get();

        return view('home.mis_recetas.edit', compact('receta', 'ingredientes', 'ingredientesSeleccionados'));
    }

    public function update(Request $request, Receta $receta)
    {
        // Validaciones
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'pasosPreparacion' => 'required|string',
            'caloriasConsumidas' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:svg,png,jpg,jpeg,webp|max:2048',
            'ingredientes' => 'required|array',
            'ingredientes.*.id' => 'required|integer|exists:ingredientes,id',
            'ingredientes.*.cantidad' => 'required|integer|min:1',
            'ingredientes.*.unidadMedida' => 'required|string|max:50',
        ]);

        // Excluir los ingredientes de los datos a actualizar
        $data = $request->except('ingredientes');

        // Procesar la imagen si se ha subido una nueva
        if ($request->hasFile('imagen')) {
            if ($receta->imagen) {
                // Eliminar la imagen anterior de Cloudinary
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

        // Actualizar la receta
        $receta->update($data);

        // Sincronizar los ingredientes con cantidades y unidades
        $ingredientesData = [];
        foreach ($request->input('ingredientes') as $ingredienteData) {
            $ingredientesData[$ingredienteData['id']] = [
                'cantidad' => $ingredienteData['cantidad'],
                'unidadMedida' => $ingredienteData['unidadMedida'],
            ];
        }
        $receta->ingredientes()->sync($ingredientesData);

        return redirect()->route('mis-recetas.index')->with('success', 'Receta actualizada exitosamente.');
    }

    public function destroy(Receta $receta)
    {
        // Verifica si la receta está asociada a algún usuario o plan alimenticio
        if ($receta->usuariosFavoritos()->exists()) {
            return redirect()->route('mis-recetas.index')
            ->with('error', 'No se puede eliminar la receta porque está en uso.');
        }

        // Si no está asociada, se permite la eliminación
        $receta->delete();

        return redirect()->route('mis-recetas.index')
        ->with('success', 'Receta eliminada exitosamente.');
    }
}
