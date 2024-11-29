@extends('layouts.app')

@section('content')

<!-- Mostrar Recetas -->
<div class="container mt-4">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('mis-recetas.create') }}" class="btn btn-success mb-3">Crear Nueva Receta</a>

    @if($recetas->isEmpty())
    <p>No hay recetas disponibles.</p>
    @else
    <div class="row">
        @foreach($recetas as $receta)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $receta->imagen }}" class="card-img-top" alt="{{ $receta->titulo }}" style="object-fit: cover; height: 200px;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $receta->titulo }}</h5>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('mis-recetas.edit', $receta) }}" class="btn btn-primary mr-4">Editar</a>
                            <form action="{{ route('mis-recetas.destroy', $receta) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta receta?')">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection