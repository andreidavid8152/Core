@extends('layouts.app')

@section('content')

<h1>Editar Receta</h1>

<form action="{{ route('mis-recetas.update', $receta->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Título -->
    <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ $receta->titulo }}" placeholder="Ejemplo: Ensalada César" required>
    </div>

    <!-- Descripción -->
    <div class="form-group mt-3">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4" placeholder="Breve descripción de la receta" required>{{ $receta->descripcion }}</textarea>
    </div>

    <!-- Pasos de Preparación -->
    <div class="form-group mt-3">
        <label for="pasosPreparacion">Pasos de Preparación</label>
        <textarea name="pasosPreparacion" class="form-control" rows="6" placeholder="Paso a paso de cómo preparar la receta" required>{{ $receta->pasosPreparacion }}</textarea>
        <small class="form-text text-muted">Escribe cada paso en una línea separada. Presiona Enter para crear un nuevo paso.</small>
    </div>

    <!-- Calorías Consumidas -->
    <div class="form-group mt-3">
        <label for="caloriasConsumidas">Calorías Consumidas</label>
        <input type="number" name="caloriasConsumidas" class="form-control" value="{{ $receta->caloriasConsumidas }}" placeholder="Ejemplo: 250" min="0" required>
    </div>

    <!-- Imagen -->
    <div class="form-group mt-3">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
        <small class="form-text text-muted">Si no seleccionas una nueva imagen, se mantendrá la imagen actual.</small>
        @if($receta->imagen)
        <div class="mt-2">
            <img src="{{ $receta->imagen }}" alt="Imagen actual" class="img-thumbnail" style="max-height: 200px;">
        </div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary mt-3 mb-5">Actualizar</button>
    <a href="{{ route('mis-recetas.index') }}" class="btn btn-secondary mt-3 mb-5">Cancelar</a>
</form>

@endsection