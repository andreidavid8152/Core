@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Lista de Preferencias</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('preferencias.create') }}" class="btn btn-primary mb-4">Nueva Preferencia</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preferencias as $preferencia)
            <tr>
                <td>{{ $preferencia->id }}</td>
                <td>{{ $preferencia->descripcion }}</td>
                <td>
                    <a href="{{ route('preferencias.edit', $preferencia->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('preferencias.destroy', $preferencia->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta preferencia?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-4">Volver</a>
</div>
@endsection