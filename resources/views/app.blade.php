<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nosecaen') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            body { padding: 16px; }
        </style>
    @endif
    @inertiaHead
</head>
<body>
    <div id="inertia-loading" class="container mt-4">
        <div class="alert alert-info mb-0">
            Cargando...
        </div>
    </div>
    @inertia
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if (!file_exists(public_path('build/manifest.json')))
        <div class="alert alert-danger mt-3">
            No se han compilado los assets de Vite (falta public/build/manifest.json). Ejecuta npm install y npm run build (o npm run dev).
        </div>
    @endif
</body>
</html>
