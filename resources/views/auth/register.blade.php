@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-header text-center bg-success text-white">
                <h4 class="mb-0">Únete a NutriCore</h4>
                <small>Crea una cuenta para comenzar</small>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-semibold">Nombre:</label>
                        <input type="text" class="form-control rounded-pill" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold">Correo electrónico:</label>
                        <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="ejemplo@nutricore.com" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Contraseña:</label>
                        <small class="form-text text-muted">La contraseña debe tener al menos 4 caracteres.</small>
                        <input type="password" class="form-control rounded-pill" id="password" name="password"
                            placeholder="Crea una contraseña segura" minlength="4" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success rounded-pill">Registrarse</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-success">¿Ya tienes una cuenta? Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection