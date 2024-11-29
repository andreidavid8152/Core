@extends('layouts.app')

@section('content')

<div class="container mt-4">
    @if (isset($mensaje))
        <div class="alert alert-warning">
            <h4>{{ $mensaje }}</h4>
            <ul>
                @foreach ($errores as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p>
                Por favor, ve a la sección de perfil y completa la información necesaria.
            </p>
        </div>
    @else
        @if ($recomendaciones && count($recomendaciones) > 0)
            <ul>
                @foreach ($recomendaciones as $recomendacion)
                    <li>
                        <strong>{{ $recomendacion['receta']->titulo }}</strong> - 
                        Compatibilidad: {{ $recomendacion['compatibilidad'] }}%
                        <p>{{ $recomendacion['receta']->descripcion }}</p>
                        <p>
                            Recomendado en base a: {{ $recomendacion['usuario']->nombre }}
                        </p>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center text-muted">No se encontraron recomendaciones en este momento.</p>
        @endif
    @endif
</div>
@endsection
