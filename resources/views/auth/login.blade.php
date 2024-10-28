@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-header text-center bg-success text-white">
                <h4 class="mb-0">Bienvenido a NutriCore</h4>
                <small>Inicia sesión para continuar</small>
            </div>
            <div class="card-body p-4">
                <!-- Mostrar errores si existen -->
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Correo electrónico:</label>
                        <input type="email" class="form-control rounded-pill" name="email" placeholder="ejemplo@nutricore.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Contraseña:</label>
                        <input type="password" class="form-control rounded-pill" name="password" minlength="4" placeholder="Ingresa tu contraseña" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success rounded-pill">Iniciar Sesión</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('register') }}" class="text-success">¿No tienes una cuenta? Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection