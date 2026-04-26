@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-user-edit me-2"></i>Editar Cliente</h2>
    <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.clientes.update', $cliente) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- CIF --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">CIF <span class="text-danger">*</span></label>
                    <input type="text"
                           name="cif"
                           class="form-control @error('cif') is-invalid @enderror"
                           value="{{ old('cif', $cliente->cif) }}">
                    @error('cif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nombre --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $cliente->nombre) }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                    <input type="text"
                           name="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $cliente->telefono) }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Correo <span class="text-danger">*</span></label>
                    <input type="email"
                           name="correo"
                           class="form-control @error('correo') is-invalid @enderror"
                           value="{{ old('correo', $cliente->correo) }}">
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Cuenta corriente --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cuenta Corriente</label>
                    <input type="text"
                           name="cuenta_corriente"
                           class="form-control @error('cuenta_corriente') is-invalid @enderror"
                           value="{{ old('cuenta_corriente', $cliente->cuenta_corriente) }}">
                    @error('cuenta_corriente')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- País --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">País</label>
                    <input type="text"
                           name="pais"
                           class="form-control @error('pais') is-invalid @enderror"
                           value="{{ old('pais', $cliente->pais) }}">
                    @error('pais')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Moneda --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Moneda</label>
                    <input type="text"
                           name="moneda"
                           class="form-control @error('moneda') is-invalid @enderror"
                           value="{{ old('moneda', $cliente->moneda) }}">
                    @error('moneda')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Importe cuota --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Importe Cuota Mensual <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number"
                               name="importe_cuota"
                               class="form-control @error('importe_cuota') is-invalid @enderror"
                               value="{{ old('importe_cuota', $cliente->importe_cuota) }}"
                               step="0.01"
                               min="0">
                        <span class="input-group-text">€</span>
                    </div>
                    @error('importe_cuota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.clientes.index') }}" class="btn btn-secondary me-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection