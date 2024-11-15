@extends('layouts.app')

@section('content')

<h1>Crear Receta</h1>

<form action="{{ route('mis-recetas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Título -->
    <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" class="form-control" placeholder="Ejemplo: Ensalada César" required>
    </div>

    <!-- Descripción -->
    <div class="form-group mt-3">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4" placeholder="Breve descripción de la receta" required></textarea>
    </div>

    <!-- Pasos de Preparación -->
    <div class="form-group mt-3">
        <label for="pasosPreparacion">Pasos de Preparación</label>
        <textarea name="pasosPreparacion" class="form-control" rows="6" placeholder="Paso a paso de cómo preparar la receta" required></textarea>
        <small class="form-text text-muted">Escribe cada paso en una línea separada. Presiona Enter para crear un nuevo paso.</small>
    </div>

    <!-- Calorías Consumidas -->
    <div class="form-group mt-3">
        <label for="caloriasConsumidas">Calorías Consumidas</label>
        <input type="number" name="caloriasConsumidas" class="form-control" placeholder="Ejemplo: 250" min="0" required>
    </div>

    <!-- Imagen -->
    <div class="form-group mt-3">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    <a href="{{ route('mis-recetas.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
</form>

@endsection