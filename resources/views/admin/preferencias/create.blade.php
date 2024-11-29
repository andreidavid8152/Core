@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Crear Nueva Preferencia</h1>

    <form action="{{ route('preferencias.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" class="form-control" required>
            @error('descripcion')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Guardar</button>
        <a href="{{ route('preferencias.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection