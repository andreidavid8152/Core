@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Editar Ingrediente</h1>

    <form action="{{ route('ingredientes.update', $ingrediente->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre del Ingrediente</label>
            <input type="text" name="nombre" class="form-control" value="{{ $ingrediente->nombre }}" required>
            @error('nombre')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('ingredientes.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection