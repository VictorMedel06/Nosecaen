@extends('layouts.app')

@section('content')

{{-- Hero --}}
<div class="welcome-hero">
    <i class="fa fa-elevator fa-3x mb-3" style="opacity:0.9"></i>
    <h1>Nosecaen S.L.</h1>
    <p>Sistema de Gestión de Incidencias y Mantenimiento de Ascensores</p>
</div>

{{-- Tarjetas de acceso --}}
<div class="row justify-content-center g-4">
    <div class="col-md-4">
        <div class="welcome-card"
             style="background: linear-gradient(135deg, #1565C0, #1E88E5);"
             onclick="window.location='{{ route('login') }}'">
            <div class="icon-circle" style="background: rgba(255,255,255,0.2);">
                <i class="fa fa-sign-in-alt text-white"></i>
            </div>
            <h4 class="text-white fw-bold">Soy Empleado</h4>
            <p class="text-white" style="opacity:0.85">
                Accede al panel de gestión de incidencias
            </p>
            <a href="{{ route('login') }}" class="btn btn-light fw-bold">
                <i class="fa fa-arrow-right me-1"></i> Iniciar Sesión
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="welcome-card"
             style="background: linear-gradient(135deg, #F57F17, #FB8C00);"
             onclick="window.location='{{ route('incidencia.index') }}'">
            <div class="icon-circle" style="background: rgba(255,255,255,0.2);">
                <i class="fa fa-exclamation-triangle text-white"></i>
            </div>
            <h4 class="text-white fw-bold">Soy Cliente</h4>
            <p class="text-white" style="opacity:0.85">
                Registra una incidencia o avería en tu ascensor
            </p>
            <a href="{{ route('incidencia.index') }}" class="btn btn-light fw-bold">
                <i class="fa fa-arrow-right me-1"></i> Registrar Incidencia
            </a>
        </div>
    </div>
</div>

{{-- Info footer --}}
<div class="text-center mt-5 text-muted">
    <small>
        <i class="fa fa-phone me-1"></i> 959 000 000 &nbsp;|&nbsp;
        <i class="fa fa-envelope me-1"></i> info@nosecaen.com &nbsp;|&nbsp;
        <i class="fa fa-map-marker-alt me-1"></i> Huelva, España
    </small>
</div>

@endsection