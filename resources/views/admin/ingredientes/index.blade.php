@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Lista de Ingredientes</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('ingredientes.create') }}" class="btn btn-primary mb-4">Nuevo Ingrediente</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingredientes as $ingrediente)
            <tr>
                <td>{{ $ingrediente->id }}</td>
                <td>{{ $ingrediente->nombre }}</td>
                <td>
                    <a href="{{ route('ingredientes.edit', $ingrediente->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('ingredientes.destroy', $ingrediente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este ingrediente?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver</a>
</div>
@endsection