@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-title mb-0">
            <i class="fa fa-tachometer-alt me-2"></i>Panel de Administración
        </h2>
        <small class="text-muted">Bienvenido, {{ auth()->user()->nombre ?? auth()->user()->name }}</small>
    </div>
    <span class="badge bg-danger fs-6">
        <i class="fa fa-shield-alt me-1"></i> Administrador
    </span>
</div>

{{-- Tarjetas de estadísticas --}}
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1565C0, #1E88E5)">
            <i class="fa fa-list stat-icon"></i>
            <span class="stat-number">{{ \App\Models\Tarea::count() }}</span>
            <span class="stat-label">Total Tareas</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #2E7D32, #43A047)">
            <i class="fa fa-users stat-icon"></i>
            <span class="stat-number">{{ \App\Models\Cliente::count() }}</span>
            <span class="stat-label">Clientes</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #6A1B9A, #8E24AA)">
            <i class="fa fa-user-tie stat-icon"></i>
            <span class="stat-number">{{ \App\Models\User::where('tipo','operario')->count() }}</span>
            <span class="stat-label">Operarios</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #E65100, #F4511E)">
            <i class="fa fa-file-invoice-dollar stat-icon"></i>
            <span class="stat-number">{{ \App\Models\Cuota::where('pagada',false)->count() }}</span>
            <span class="stat-label">Cuotas Pendientes</span>
        </div>
    </div>
</div>

{{-- Accesos rápidos --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="fa fa-bolt me-2"></i>Accesos Rápidos
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.tareas.create') }}"
                       class="btn btn-primary text-start">
                        <i class="fa fa-plus me-2"></i>Nueva Tarea
                    </a>
                    <a href="{{ route('admin.clientes.create') }}"
                       class="btn btn-success text-start">
                        <i class="fa fa-user-plus me-2"></i>Nuevo Cliente
                    </a>
                    <a href="{{ route('admin.cuotas.index') }}"
                       class="btn btn-warning text-start">
                        <i class="fa fa-calendar me-2"></i>Gestionar Cuotas
                    </a>
                    <a href="{{ route('admin.empleados.create') }}"
                       class="btn btn-secondary text-start">
                        <i class="fa fa-user-tie me-2"></i>Nuevo Empleado
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="fa fa-clock me-2"></i>Últimas Tareas Pendientes
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Descripción</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Tarea::with('cliente')->where('estado','P')->latest()->take(5)->get() as $tarea)
                        <tr>
                            <td>{{ Str::limit($tarea->descripcion, 30) }}</td>
                            <td>{{ $tarea->cliente?->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge bg-warning">Pendiente</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                No hay tareas pendientes
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
