@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-file-invoice-dollar me-2"></i>Cuotas</h2>
    <div>
        <a href="{{ route('admin.cuotas.create') }}" class="btn btn-primary me-2">
            <i class="fa fa-plus me-1"></i> Nueva Cuota
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#modalRemesa">
            <i class="fa fa-calendar me-1"></i> Remesa Mensual
        </button>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Concepto</th>
                    <th>Fecha Emisión</th>
                    <th>Importe</th>
                    <th>Estado</th>
                    <th>Fecha Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cuotas as $cuota)
                <tr>
                    <td>{{ $cuota->cliente?->nombre ?? '-' }}</td>
                    <td>{{ $cuota->concepto }}</td>
                    <td>{{ $cuota->fecha_emision->format('d/m/Y') }}</td>
                    <td>{{ number_format($cuota->importe, 2) }} {{ $cuota->cliente?->moneda }}</td>
                    <td>
                        @if($cuota->pagada)
                            <span class="badge bg-success">Pagada</span>
                        @else
                            <span class="badge bg-danger">Pendiente</span>
                        @endif
                    </td>
                    <td>{{ $cuota->fecha_pago?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.cuotas.show', $cuota) }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.cuotas.factura', $cuota) }}"
                           class="btn btn-sm btn-dark" title="Descargar factura PDF">
                            <i class="fa fa-file-pdf"></i>
                        </a>
                        <a href="{{ route('admin.cuotas.edit', $cuota) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>
                        @if(!$cuota->pagada)
                        <form action="{{ route('admin.cuotas.pagada', $cuota) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success"
                                    title="Marcar como pagada">
                                <i class="fa fa-check"></i>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.cuotas.destroy', $cuota) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('¿Seguro que quieres eliminar esta cuota?')">
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
                        No hay cuotas registradas todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Remesa Mensual --}}
<div class="modal fade" id="modalRemesa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fa fa-calendar me-2"></i>Crear Remesa Mensual
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.cuotas.remesa') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">
                        Se creará una cuota para <strong>todos los clientes</strong>
                        usando el importe de su cuota mensual.
                    </p>
                    <div class="mb-3">
                        <label class="form-label">Concepto <span class="text-danger">*</span></label>
                        <input type="text"
                               name="concepto"
                               class="form-control"
                               value="Cuota mensual {{ now()->format('F Y') }}"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha Emisión <span class="text-danger">*</span></label>
                        <input type="date"
                               name="fecha_emision"
                               class="form-control"
                               value="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check me-1"></i> Crear Remesa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
