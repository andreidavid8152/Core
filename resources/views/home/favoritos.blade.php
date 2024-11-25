@extends('layouts.app')

@section('content')

<div class="container mt-4">
    @if($favoritos->isEmpty())
    <p class="text-center text-muted">No tienes recetas marcadas como favoritas.</p>
    @else
    <div class="row">
        @foreach($favoritos as $receta)
        <div class="col-md-4 d-flex align-items-stretch mb-4">
            <div class="card mb-4 h-100 d-flex flex-column">
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ $receta->imagen }}" class="img-fluid rounded w-100 h-100" alt="{{ $receta->titulo }}" style="object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $receta->titulo }}</h5>
                    <p class="card-text">{{ Str::limit($receta->descripcion, 100) }}</p>
                    <a href="{{ route('recetas.show', ['id' => $receta->id]) }}" class="btn btn-warning mt-auto">Ver Receta</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection