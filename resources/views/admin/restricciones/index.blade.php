@extends('layouts.app')

@section('content')
<div class="container">
    
    <h1>Lista de Restricciones</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('restricciones.create') }}" class="btn btn-primary mb-4">Nueva Restricción</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($restricciones as $restriccion)
            <tr>
                <td>{{ $restriccion->id }}</td>
                <td>{{ $restriccion->descripcion }}</td>
                <td>
                    <a href="{{ route('restricciones.edit', $restriccion->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('restricciones.destroy', $restriccion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta restricción?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver</a>
</div>
@endsection