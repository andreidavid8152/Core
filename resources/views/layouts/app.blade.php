<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutricore</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ session('usuario')->email === 'admin@super.com' ? route('admin.dashboard') : route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="NutriCore Logo" class="img-fluid" style="max-height: 45px;">
        </a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                @if(session('usuario'))
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container mt-4">

        <!-- Mostrar el navbar secundario solo en rutas específicas -->
        @if(Request::routeIs('home', 'mis-recetas.index', 'favoritos', 'recomendaciones'))
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
            <div class="container">
                <ul class="navbar-nav mx-auto">
                    <!-- Home -->
                    <li class="nav-item mr-5">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <!-- Mis Recetas -->
                    <li class="nav-item mr-5">
                        <a class="nav-link {{ Route::is('mis-recetas.index') ? 'active' : '' }}" href="{{ route('mis-recetas.index') }}">Mis Recetas</a>
                    </li>
                    <!-- Favoritos -->
                    <li class="nav-item mr-5">
                        <a class="nav-link {{ Route::is('favoritos') ? 'active' : '' }}" href="{{ route('favoritos') }}">Favoritos</a>
                    </li>
                    <!-- Recomendaciones -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('recomendaciones') ? 'active' : '' }}" href="{{ route('recomendaciones') }}">Recomendaciones</a>
                    </li>
                </ul>
            </div>
        </nav>
        @endif

        @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>