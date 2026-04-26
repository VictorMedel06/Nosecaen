@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-user me-2"></i>{{ $empleado->nombre ?? $empleado->name }}</h2>
    <div>
        <a href="{{ route('admin.empleados.edit', $empleado) }}" class="btn btn-warning me-2">
            <i class="fa fa-edit me-1"></i> Editar
        </a>
        <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-info-circle me-2"></i>Datos del Empleado
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-2">
                <strong>DNI:</strong><br>{{ $empleado->dni ?? '-' }}
            </div>
            <div class="col-md-5 mb-2">
                <strong>Nombre:</strong><br>{{ $empleado->nombre ?? $empleado->name }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Email:</strong><br>{{ $empleado->email }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Teléfono:</strong><br>{{ $empleado->telefono ?? '-' }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Dirección:</strong><br>{{ $empleado->direccion ?? '-' }}
            </div>
            <div class="col-md-2 mb-2">
                <strong>Fecha Alta:</strong><br>
                {{ $empleado->fecha_alta?->format('d/m/Y') ?? '-' }}
            </div>
            <div class="col-md-2 mb-2">
                <strong>Tipo:</strong><br>
                @if($empleado->tipo === 'admin')
                    <span class="badge bg-danger">Administrador</span>
                @else
                    <span class="badge bg-primary">Operario</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Tareas asignadas --}}
@if($empleado->isOperario())
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <span><i class="fa fa-list me-2"></i>Tareas Asignadas</span>
        <span class="badge bg-secondary">{{ $empleado->tareas->count() }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha realización</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleado->tareas as $tarea)
                <tr>
                    <td>{{ $tarea->descripcion }}</td>
                    <td>
                        @if($tarea->estado === 'P')
                            <span class="badge bg-warning text-dark">Pendiente</span>
                        @elseif($tarea->estado === 'R')
                            <span class="badge bg-success">Realizada</span>
                        @else
                            <span class="badge bg-danger">Cancelada</span>
                        @endif
                    </td>
                    <td>{{ $tarea->fecha_realizacion?->format('d/m/Y') ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-3">
                        No tiene tareas asignadas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection 