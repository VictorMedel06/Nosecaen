@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-user-tie me-2"></i>Empleados</h2>
    <a href="{{ route('admin.empleados.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-1"></i> Nuevo Empleado
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Tipo</th>
                    <th>Fecha Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->dni ?? '-' }}</td>
                    <td>{{ $empleado->nombre ?? $empleado->name }}</td>
                    <td>{{ $empleado->email }}</td>
                    <td>{{ $empleado->telefono ?? '-' }}</td>
                    <td>
                        @if($empleado->tipo === 'admin')
                            <span class="badge bg-danger">Administrador</span>
                        @else
                            <span class="badge bg-primary">Operario</span>
                        @endif
                    </td>
                    <td>{{ $empleado->fecha_alta?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.empleados.show', $empleado) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.empleados.edit', $empleado) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if($empleado->id !== auth()->id())
                        <form action="{{ route('admin.empleados.destroy', $empleado) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este empleado?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No hay empleados registrados todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection