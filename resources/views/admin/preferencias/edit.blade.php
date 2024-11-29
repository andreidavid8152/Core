@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Editar Preferencia</h1>

    <form action="{{ route('preferencias.update', $preferencia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" class="form-control" value="{{ $preferencia->descripcion }}" required>
            @error('descripcion')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('preferencias.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection