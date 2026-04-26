@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-file-invoice-dollar me-2"></i>Detalle de Cuota</h2>
    <div>
        <a href="{{ route('admin.cuotas.factura', $cuota) }}" class="btn btn-dark me-2" target="_blank">
            <i class="fa fa-file-pdf me-1"></i> Descargar Factura PDF
        </a>
        <a href="{{ route('admin.cuotas.edit', $cuota) }}" class="btn btn-warning me-2">
            <i class="fa fa-edit me-1"></i> Editar
        </a>
        <a href="{{ route('admin.cuotas.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-info-circle me-2"></i>Datos de la Cuota
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Cliente:</strong><br>
                {{ $cuota->cliente?->nombre ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Concepto:</strong><br>
                {{ $cuota->concepto }}
            </div>
            <div class="col-md-4 mb-3">
                <strong>Fecha Emisión:</strong><br>
                {{ $cuota->fecha_emision->format('d/m/Y') }}
            </div>
            <div class="col-md-4 mb-3">
                <strong>Importe:</strong><br>
                {{ number_format($cuota->importe, 2) }} {{ $cuota->cliente?->moneda }}
            </div>
            <div class="col-md-4 mb-3">
                <strong>Estado:</strong><br>
                @if($cuota->pagada)
                    <span class="badge bg-success fs-6">Pagada</span>
                @else
                    <span class="badge bg-danger fs-6">Pendiente de pago</span>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <strong>Fecha de Pago:</strong><br>
                {{ $cuota->fecha_pago?->format('d/m/Y') ?? '-' }}
            </div>
            <div class="col-md-4 mb-3">
                <strong>Importe en Euros:</strong><br>
                {{ $cuota->importe_euros ? number_format($cuota->importe_euros, 2) . ' €' : '-' }}
            </div>
            <div class="col-md-12 mb-3">
                <strong>Notas:</strong><br>
                {{ $cuota->notas ?? 'Sin notas.' }}
            </div>
        </div>

        @if(!$cuota->pagada)
        <div class="d-flex justify-content-end">
            <form action="{{ route('admin.cuotas.pagada', $cuota) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-check me-1"></i> Marcar como Pagada
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
