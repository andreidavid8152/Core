@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Recetas Más Similares y Favoritas</h3>

    @if (count($similitudes) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Receta A</th>
                    <th>Receta B</th>
                    <th>Similitud (%)</th>
                    <th>Favoritos Receta A</th>
                    <th>Favoritos Receta B</th>
                    <th>Total Favoritos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($similitudes as $similitud)
                    <tr>
                        <td>{{ $similitud['receta_a']->titulo }}</td>
                        <td>{{ $similitud['receta_b']->titulo }}</td>
                        <td>{{ $similitud['similitud'] }}%</td>
                        <td>{{ $similitud['receta_a']->usuarios_favoritos_count }}</td>
                        <td>{{ $similitud['receta_b']->usuarios_favoritos_count }}</td>
                        <td>{{ $similitud['total_favoritos'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se encontraron recetas similares.</p>
    @endif
</div>
@endsection
