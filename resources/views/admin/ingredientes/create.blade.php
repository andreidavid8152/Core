@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Crear Nuevo Ingrediente</h1>

    <form action="{{ route('ingredientes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Ingrediente</label>
            <input type="text" name="nombre" class="form-control" required>
            @error('nombre')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        <a href="{{ route('ingredientes.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection