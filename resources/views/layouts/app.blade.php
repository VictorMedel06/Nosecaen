<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ request()->getSchemeAndHttpHost() . request()->getBaseUrl() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosecaen - {{ $title ?? 'Panel' }}</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/nosecaen.css') }}" rel="stylesheet">

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- DataTables CSS --}}
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/js/app.js'])
    @endif

    @if (isset($page))
        @inertiaHead
    @endif
</head>
<body class="bg-light">

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ auth()->check() ? route('dashboard') : route('home') }}">
            <i class="fa fa-elevator me-2"></i> Nosecaen
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">

                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-gauge-high me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.tareas.index') }}">
                                <i class="fa fa-list me-1"></i> Tareas
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-users me-1"></i> Clientes
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.clientes.index') }}">
                                        <i class="fa fa-list me-1"></i> Vista Normal
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.clientes.vue') }}">
                                        <i class="fab fa-vuejs me-1"></i> Vista Vue
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user-tie me-1"></i> Empleados
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.empleados.index') }}">
                                        <i class="fa fa-list me-1"></i> Vista Normal
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.empleados.inertia') }}">
                                        <i class="fab fa-vuejs me-1"></i> Vista Inertia
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.cuotas.index') }}">
                                <i class="fa fa-file-invoice-dollar me-1"></i> Cuotas
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operario.dashboard') }}">
                                <i class="fa fa-gauge-high me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('operario.tareas.index') }}">
                                <i class="fa fa-list me-1"></i> Mis Tareas
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>

            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fa fa-user me-1"></i>
                            {{ auth()->user()->nombre ?? auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fa fa-sign-out-alt me-1"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- CONTENIDO PRINCIPAL --}}
<div class="container mt-4">

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-times-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Errores de validación --}}
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    @yield('content')

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery (necesario para DataTables) --}}
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

@stack('scripts')

</body>
</html>
