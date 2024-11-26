@extends('layouts.app')

@section('content')

<h1>Perfil del Usuario</h1>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('perfil.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card mb-3 mt-4">
        <div class="card-header">
            Información Personal
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email (no editable)</label>
                <input type="email" id="email" class="form-control" value="{{ $usuario->email }}" disabled>
            </div>

            <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" name="peso" id="peso" class="form-control" value="{{ $usuario->peso }}" step="0.01" min="0" max="999.99">
            </div>

            <div class="mb-3">
                <label for="altura" class="form-label">Altura (m)</label>
                <input type="number" name="altura" id="altura" class="form-control" value="{{ $usuario->altura }}" step="0.01" min="0" max="99.99">
            </div>

            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="edad" id="edad" class="form-control" value="{{ $usuario->edad }}">
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" id="sexo" class="form-control" required>
                    <option value="" disabled {{ is_null($usuario->sexo) ? 'selected' : '' }}>Seleccione</option>
                    <option value="Masculino" {{ $usuario->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $usuario->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="caloriasPorComida" class="form-label">Calorías por comida</label>
                <input type="number" name="caloriasPorComida" id="caloriasPorComida" class="form-control" value="{{ $usuario->caloriasPorComida }}">
            </div>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
    </div>
</form>

@endsection