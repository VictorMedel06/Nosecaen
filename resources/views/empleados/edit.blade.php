@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-user-edit me-2"></i>Editar Empleado</h2>
    <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.empleados.update', $empleado) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- DNI --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">DNI <span class="text-danger">*</span></label>
                    <input type="text"
                           name="dni"
                           class="form-control @error('dni') is-invalid @enderror"
                           value="{{ old('dni', $empleado->dni) }}">
                    @error('dni')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nombre --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
                    <input type="text"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $empleado->nombre) }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $empleado->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text"
                           name="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono', $empleado->telefono) }}">
                    @error('telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nueva Contraseña
                        <small class="text-muted">(dejar vacío para no cambiar)</small>
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirmar Nueva Contraseña</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control">
                </div>

                {{-- Dirección --}}
                <div class="col-md-8 mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text"
                           name="direccion"
                           class="form-control @error('direccion') is-invalid @enderror"
                           value="{{ old('direccion', $empleado->direccion) }}">
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Fecha alta --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de Alta</label>
                    <input type="date"
                           name="fecha_alta"
                           class="form-control @error('fecha_alta') is-invalid @enderror"
                           value="{{ old('fecha_alta', $empleado->fecha_alta?->format('Y-m-d')) }}">
                    @error('fecha_alta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tipo --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo <span class="text-danger">*</span></label>
                    <select name="tipo"
                            class="form-select @error('tipo') is-invalid @enderror">
                        <option value="operario"
                            {{ old('tipo', $empleado->tipo) === 'operario' ? 'selected' : '' }}>
                            Operario
                        </option>
                        <option value="admin"
                            {{ old('tipo', $empleado->tipo) === 'admin' ? 'selected' : '' }}>
                            Administrador
                        </option>
                    </select>
                    @error('tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.empleados.index') }}" class="btn btn-secondary me-2">
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