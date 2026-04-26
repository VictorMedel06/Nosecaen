@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-list me-2"></i>Tareas</h2>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('admin.tareas.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-1"></i> Nueva Tarea
    </a>
    @endif
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Contacto</th>
                    <th>Operario</th>
                    <th>Estado</th>
                    <th>Fecha realización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tareas as $tarea)
                <tr>
                    <td>{{ $tarea->cliente?->nombre ?? '-' }}</td>
                    <td>{{ Str::limit($tarea->descripcion, 50) }}</td>
                    <td>
                        {{ $tarea->persona_contacto }}<br>
                        <small class="text-muted">{{ $tarea->telefono_contacto }}</small>
                    </td>
                    <td>{{ $tarea->operario?->nombre ?? 'Sin asignar' }}</td>
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
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.tareas.show', $tarea) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.tareas.edit', $tarea) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.tareas.destroy', $tarea) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar esta tarea?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('operario.tareas.show', $tarea) }}"
                               class="btn btn-sm btn-info text-white">
                                <i class="fa fa-eye"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No hay tareas registradas todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection