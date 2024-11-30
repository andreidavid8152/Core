<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>NutriCore</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ secure_asset('css/welcome.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="text-center">
            <h1 class="hero-title">Bienvenido a NutriCore</h1>
            <p class="hero-subtitle">Recetas personalizadas para tu salud y bienestar</p>
            <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-4">Únete Ahora</a>
                <a href="{{ route('login') }}" class="btn btn-dark btn-lg">Iniciar Sesión</a>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container my-5 section-funcionalidades">
        <div class="row text-center mb-4">
            <h2 class="fw-bold">Funcionalidades de NutriCore</h2>
            <p class="text-muted">Explora lo que puedes hacer en nuestra plataforma</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="{{ asset('images/recetas.webp') }}" class="card-img-top" alt="Subir Recetas">
                    <div class="card-body">
                        <h5 class="card-title">Sube tus Recetas</h5>
                        <p class="card-text">Comparte tus mejores recetas con la comunidad de NutriCore.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="{{ asset('images/favoritos.webp') }}" class="card-img-top" alt="Favoritos">
                    <div class="card-body">
                        <h5 class="card-title">Recetas Favoritas</h5>
                        <p class="card-text">Marca tus recetas favoritas para un acceso rápido y organizado.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <img src="{{ asset('images/recomendaciones.webp') }}" class="card-img-top" alt="Recomendaciones">
                    <div class="card-body">
                        <h5 class="card-title">Recomendaciones Personalizadas</h5>
                        <p class="card-text">Recibe sugerencias de recetas basadas en tus preferencias y necesidades.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4">
        <p class="text-muted">NutriCore © {{ date('Y') }} - Todos los derechos reservados</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>