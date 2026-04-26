@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-user me-2"></i>{{ $cliente->nombre }}</h2>
    <div>
        <a href="{{ route('admin.clientes.edit', $cliente) }}" class="btn btn-warning me-2">
            <i class="fa fa-edit me-1"></i> Editar
        </a>
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

{{-- Datos del cliente --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-info-circle me-2"></i>Datos del Cliente
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 mb-2">
                <strong>CIF:</strong><br>{{ $cliente->cif }}
            </div>
            <div class="col-md-5 mb-2">
                <strong>Nombre:</strong><br>{{ $cliente->nombre }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Teléfono:</strong><br>{{ $cliente->telefono }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Correo:</strong><br>{{ $cliente->correo }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Cuenta Corriente:</strong><br>{{ $cliente->cuenta_corriente ?? '-' }}
            </div>
            <div class="col-md-2 mb-2">
                <strong>País:</strong><br>{{ $cliente->pais ?? '-' }}
            </div>
            <div class="col-md-2 mb-2">
                <strong>Moneda:</strong><br>{{ $cliente->moneda ?? '-' }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Cuota Mensual:</strong><br>
                {{ number_format($cliente->importe_cuota, 2) }} {{ $cliente->moneda }}
            </div>
        </div>
    </div>
</div>

{{-- Tareas del cliente --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <span><i class="fa fa-list me-2"></i>Tareas</span>
        <span class="badge bg-secondary">{{ $cliente->tareas->count() }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha realización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cliente->tareas as $tarea)
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
                    <td>
                        <a href="{{ route('admin.tareas.show', $tarea) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="fa fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        No hay tareas para este cliente.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Cuotas del cliente --}}
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white d-flex justify-content-between">
        <span><i class="fa fa-file-invoice-dollar me-2"></i>Cuotas</span>
        <span class="badge bg-secondary">{{ $cliente->cuotas->count() }}</span>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Concepto</th>
                    <th>Fecha emisión</th>
                    <th>Importe</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cliente->cuotas as $cuota)
                <tr>
                    <td>{{ $cuota->concepto }}</td>
                    <td>{{ $cuota->fecha_emision->format('d/m/Y') }}</td>
                    <td>{{ number_format($cuota->importe, 2) }} {{ $cliente->moneda }}</td>
                    <td>
                        @if($cuota->pagada)
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-danger">Pendiente</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        No hay cuotas para este cliente.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection