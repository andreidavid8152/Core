@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Administración</h1>
    <p>Bienvenido al panel de administración de NutriCore.</p>

    <!-- Estilos personalizados -->
    <style>
        .circle {
            width: 200px;
            height: 200px;
        }

        @media (max-width: 768px) {
            .circle {
                width: 150px;
                height: 150px;
            }
        }

        @media (max-width: 576px) {
            .circle {
                width: 120px;
                height: 120px;
            }
        }

        .circle-link h3 {
            color: black;
            transition: color 0.3s;
        }

        .circle-link:hover h3 {
            color: red;
        }
    </style>

    <div class="row justify-content-center mt-5">
        <!-- Preferencias -->
        <div class="col-md-4 text-center mb-5">
            <a href="{{ route('preferencias.index') }}" class="text-decoration-none circle-link">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden circle">
                    <img src="{{ asset('images/preferencias.webp') }}" alt="Preferencias" style="width: 100%; height: auto;">
                </div>
                <h3 class="mt-3">Preferencias</h3>
            </a>
        </div>
        <!-- Restricciones -->
        <div class="col-md-4 text-center mb-5">
            <a href="{{ route('restricciones.index') }}" class="text-decoration-none circle-link">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden circle">
                    <img src="{{ asset('images/restricciones.webp') }}" alt="Restricciones" style="width: 100%; height: auto;">
                </div>
                <h3 class="mt-3">Restricciones</h3>
            </a>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <!-- Ingredientes -->
        <div class="col-md-4 text-center mb-5">
            <a href="{{ route('ingredientes.index') }}" class="text-decoration-none circle-link">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto overflow-hidden circle">
                    <img src="{{ asset('images/ingredientes.webp') }}" alt="Ingredientes" style="width: 100%; height: auto;">
                </div>
                <h3 class="mt-3">Ingredientes</h3>
            </a>
        </div>
    </div>
</div>
@endsection