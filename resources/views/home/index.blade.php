@extends('layouts.app')

@section('content')

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
    <div class="container">
        <ul class="navbar-nav mx-auto">
            <!-- Home -->
            <li class="nav-item mr-5">
                <a class="nav-link active" href="{{ route('home') }}">Home</a>
            </li>
            <!-- Mis Recetas -->
            <li class="nav-item mr-5">
                <a class="nav-link" href="{{ route('mis-recetas.index') }}">Mis Recetas</a>
            </li>
            <!-- Favoritos -->
            <li class="nav-item mr-5">
                <a class="nav-link" href="{{ route('favoritos') }}">Favoritos</a>
            </li>
            <!-- Recomendaciones -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('recomendaciones') }}">Recomendaciones</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Mostrar Recetas -->
<div class="container mt-4">
    @if($recetas->isEmpty())
    <p>No hay recetas disponibles.</p>
    @else
    <div class="row">
        @foreach($recetas as $receta)
        <div class="col-md-4 d-flex align-items-stretch mb-4">
            <div class="card mb-4 h-100 d-flex flex-column">
                <div style="height: 200px; overflow: hidden;">
                    <img src="{{ $receta->imagen }}" class="img-fluid rounded w-100 h-100" alt="{{ $receta->titulo }}" style="object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $receta->titulo }}</h5>
                    <p class="card-text">{{ Str::limit($receta->descripcion, 100) }}</p>
                    <a href="#" class="btn btn-warning mt-auto">Ver Receta</a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    @endif
</div>

@endsection