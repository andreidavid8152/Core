@extends('layouts.app')

@section('content')

<div class="container mt-4">
    @if (isset($mensaje))
        <div class="alert alert-warning">
            <h4 class="alert-heading">{{ $mensaje }}</h4>
            <ul>
                @foreach ($errores as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p>Por favor, ve a la sección de perfil y completa la información necesaria.</p>
        </div>
    @else
        @if ($recomendaciones && count($recomendaciones) > 0)
            <div class="row">
                @foreach ($recomendaciones as $recomendacion)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $recomendacion['receta']->imagen }}" class="card-img-top" alt="{{ $recomendacion['receta']->titulo }}" style="object-fit: cover; height: 200px;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $recomendacion['receta']->titulo }}</h5>
                                <h6 class="card-subtitle mb-2 text-success">Compatibilidad: {{ $recomendacion['compatibilidad'] }}%</h6>
                                <p class="card-text">{{ $recomendacion['receta']->descripcion }}</p>
                                <div class="mt-auto d-flex justify-content-center">
                                    <a href="{{ route('recetas.show', $recomendacion['receta']->id) }}" class="btn btn-primary">Ver Receta</a>
                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Recomendado en base a: {{ $recomendacion['usuario']->nombre }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted">
                <p>No se encontraron recomendaciones en este momento.</p>
            </div>
        @endif
    @endif
</div>

@endsection
