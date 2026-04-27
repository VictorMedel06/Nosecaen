@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-0">
            <i class="fa fa-hard-hat me-2"></i>Panel del Operario
        </h2>
        <small class="text-muted">
            Bienvenido, {{ auth()->user()->nombre ?? auth()->user()->name }}
        </small>
    </div>
    <span class="badge bg-primary fs-6">
        <i class="fa fa-user-tie me-1"></i> Operario
    </span>
</div>

{{-- Estadísticas --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card"
             style="background: linear-gradient(135deg, #1565C0, #1E88E5)">
            <i class="fa fa-list stat-icon"></i>
            <span class="stat-number">
                {{ auth()->user()->tareas()->count() }}
            </span>
            <span class="stat-label">Total Tareas Asignadas</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card"
             style="background: linear-gradient(135deg, #E65100, #F4511E)">
            <i class="fa fa-clock stat-icon"></i>
            <span class="stat-number">
                {{ auth()->user()->tareas()->where('estado','P')->count() }}
            </span>
            <span class="stat-label">Tareas Pendientes</span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card"
             style="background: linear-gradient(135deg, #2E7D32, #43A047)">
            <i class="fa fa-check-circle stat-icon"></i>
            <span class="stat-number">
                {{ auth()->user()->tareas()->where('estado','R')->count() }}
            </span>
            <span class="stat-label">Tareas Realizadas</span>
        </div>
    </div>
</div>

{{-- Mis tareas pendientes --}}
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <span><i class="fa fa-list me-2"></i>Mis Tareas Pendientes</span>
        <a href="{{ route('operario.tareas.index') }}"
           class="btn btn-sm btn-light">
            Ver todas
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Descripción</th>
                    <th>Cliente</th>
                    <th>Fecha realización</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse(auth()->user()->tareas()->with('cliente')->where('estado','P')->latest()->take(5)->get() as $tarea)
                <tr>
                    <td>{{ Str::limit($tarea->descripcion, 40) }}</td>
                    <td>{{ $tarea->cliente?->nombre ?? '-' }}</td>
                    <td>{{ $tarea->fecha_realizacion?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <span class="badge bg-warning">Pendiente</span>
                    </td>
                    <td>
                        <a href="{{ route('operario.tareas.show', $tarea) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        No tienes tareas pendientes. ¡Bien hecho!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection