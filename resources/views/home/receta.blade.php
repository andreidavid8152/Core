@extends('layouts.app')

@section('content')
<div class="container mt-5">

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <!-- Imagen de la receta -->
                <div class="col-md-4">
                    @if($receta->imagen)
                    <img src="{{ $receta->imagen }}" class="img-fluid rounded w-100 mb-3" alt="Imagen de {{ $receta->titulo }}" style="object-fit: cover;">
                    @else
                    <div class="text-center p-5 bg-light">
                        <span class="text-muted">Sin imagen disponible</span>
                    </div>
                    @endif
                </div>
                <!-- Detalles de la receta -->
                <div class="col-md-8">
                    <!-- Título de la receta -->
                    <h1 class="card-title mb-4">{{ $receta->titulo }}</h1>
                    <!-- Descripción -->
                    <p class="card-text">{{ $receta->descripcion }}</p>
                    <!-- Detalles adicionales -->
                    <ul class="list-group list-group-flush">
                        @if($receta->caloriasConsumidas)
                        <li class="list-group-item">
                            <strong>Calorías:</strong> {{ $receta->caloriasConsumidas }} kcal
                        </li>
                        @endif
                        <li class="list-group-item">
                            <strong>Autor:</strong> {{ $receta->usuario->nombre ?? 'Anónimo' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Fecha de publicación:</strong> {{ $receta->created_at->format('d/m/Y') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Pasos de preparación -->
        <div class="card-body">
            <h4 class="card-subtitle mb-3">Pasos de Preparación</h4>
            @php
            // Dividimos los pasos por saltos de línea
            $pasos = preg_split('/\r\n|\r|\n/', $receta->pasosPreparacion);
            @endphp

            <ol>
                @foreach($pasos as $paso)
                @if(!empty(trim($paso)))
                <li>{{ $paso }}</li>
                @endif
                @endforeach
            </ol>

        </div>
        <!-- Ingredientes -->
        @if($receta->ingredientes->isNotEmpty())
        <div class="card-body">
            <h4 class="card-subtitle mb-3">Ingredientes</h4>
            <ul class="list-group">
                @foreach($receta->ingredientes as $ingrediente)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $ingrediente->nombre }}
                    <span class="badge bg-warning rounded-pill">{{ $ingrediente->pivot->cantidad }} {{ $ingrediente->pivot->unidadMedida }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <!-- Botones de interacción -->
        <div class="card-footer text-center">
            <a href="{{ route('home') }}" class="btn btn-secondary">Regresar</a>
            <form action="{{ route('recetas.favorito', $receta->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning">
                    {{ $receta->usuariosFavoritos->contains(session('usuario')->id) ? 'Quitar de Favoritos' : 'Agregar a Favoritos' }}
                </button>
            </form>
        </div>
    </div>

</div>
@endsection