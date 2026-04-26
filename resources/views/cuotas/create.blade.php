@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-plus me-2"></i>Nueva Cuota</h2>
    <a href="{{ route('admin.cuotas.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.cuotas.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Cliente --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente <span class="text-danger">*</span></label>
                    <select name="cliente_id"
                            class="form-select @error('cliente_id') is-invalid @enderror">
                        <option value="">-- Seleccionar cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Concepto --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Concepto <span class="text-danger">*</span></label>
                    <input type="text"
                           name="concepto"
                           class="form-control @error('concepto') is-invalid @enderror"
                           value="{{ old('concepto') }}"
                           placeholder="Cuota mensual mantenimiento">
                    @error('concepto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Fecha emisión --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Emisión <span class="text-danger">*</span></label>
                    <input type="date"
                           name="fecha_emision"
                           class="form-control @error('fecha_emision') is-invalid @enderror"
                           value="{{ old('fecha_emision', date('Y-m-d')) }}">
                    @error('fecha_emision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Importe --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Importe <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number"
                               name="importe"
                               class="form-control @error('importe') is-invalid @enderror"
                               value="{{ old('importe', 0) }}"
                               step="0.01"
                               min="0">
                        <span class="input-group-text">€</span>
                    </div>
                    @error('importe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pagada --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <div class="form-check mt-2">
                        <input type="checkbox"
                               name="pagada"
                               class="form-check-input"
                               id="pagada"
                               {{ old('pagada') ? 'checked' : '' }}>
                        <label class="form-check-label" for="pagada">
                            Marcar como pagada
                        </label>
                    </div>
                </div>

                {{-- Fecha pago --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de Pago</label>
                    <input type="date"
                           name="fecha_pago"
                           class="form-control @error('fecha_pago') is-invalid @enderror"
                           value="{{ old('fecha_pago') }}">
                    @error('fecha_pago')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notas --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Notas</label>
                    <textarea name="notas" rows="3"
                              class="form-control @error('notas') is-invalid @enderror"
                              placeholder="Observaciones adicionales...">{{ old('notas') }}</textarea>
                    @error('notas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.cuotas.index') }}" class="btn btn-secondary me-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Guardar Cuota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection