@extends('layouts.app')

@section('content')
<div class="text-center py-5">
    <h1 class="display-4 fw-bold">
        <i class="fa fa-elevator me-3"></i>Nosecaen S.L.
    </h1>
    <p class="lead text-muted">
        Empresa de Mantenimiento de Ascensores
    </p>
    <hr class="my-4">
    <div class="row justify-content-center mt-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fa fa-sign-in-alt fa-3x text-primary mb-3"></i>
                    <h5>Soy empleado</h5>
                    <p class="text-muted">Accede al panel de gestión</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5>Soy cliente</h5>
                    <p class="text-muted">Registra una incidencia o avería</p>
                    <a href="{{ route('incidencia.index') }}" class="btn btn-warning">
                        Registrar Incidencia
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection