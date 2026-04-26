@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-users me-2"></i>Clientes</h2>
    <a href="{{ route('admin.clientes.create') }}" class="btn btn-primary">
        <i class="fa fa-plus me-1"></i> Nuevo Cliente
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>CIF</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>País</th>
                    <th>Cuota mensual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->cif }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>{{ $cliente->pais ?? '-' }}</td>
                    <td>{{ number_format($cliente->importe_cuota, 2) }} {{ $cliente->moneda }}</td>
                    <td>
                        <a href="{{ route('admin.clientes.show', $cliente) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.clientes.edit', $cliente) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.clientes.destroy', $cliente) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        No hay clientes registrados todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection