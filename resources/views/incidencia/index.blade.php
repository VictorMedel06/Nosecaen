@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <h2 class="mb-4">
            <i class="fa fa-exclamation-triangle me-2 text-warning"></i>
            Registrar Incidencia
        </h2>

        @if(!session('cliente_verificado_id'))

            {{-- PASO 1: Verificar identidad --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <i class="fa fa-lock me-2"></i>Paso 1 — Verificar identidad
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        Introduce tu CIF y teléfono registrados para verificar tu identidad.
                    </p>
                    <form action="{{ route('incidencia.verificar') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">CIF <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="cif"
                                       class="form-control @error('cif') is-invalid @enderror"
                                       value="{{ old('cif') }}"
                                       placeholder="B12345678">
                                @error('cif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="telefono"
                                       class="form-control @error('telefono') is-invalid @enderror"
                                       value="{{ old('telefono') }}"
                                       placeholder="600000000">
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check me-1"></i> Verificar Identidad
                        </button>
                    </form>
                </div>
            </div>

        @else

            {{-- PASO 2: Formulario de incidencia --}}
            <div class="alert alert-success">
                <i class="fa fa-check-circle me-2"></i>
                Identidad verificada correctamente. Ya puedes registrar tu incidencia.
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="fa fa-clipboard me-2"></i>Paso 2 — Datos de la incidencia
                </div>
                <div class="card-body">
                    <form action="{{ route('incidencia.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            {{-- Persona contacto --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Persona de Contacto <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="persona_contacto"
                                       class="form-control @error('persona_contacto') is-invalid @enderror"
                                       value="{{ old('persona_contacto') }}"
                                       placeholder="Nombre y apellidos">
                                @error('persona_contacto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Teléfono contacto --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Teléfono <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="telefono_contacto"
                                       class="form-control @error('telefono_contacto') is-invalid @enderror"
                                       value="{{ old('telefono_contacto') }}"
                                       placeholder="600 000 000">
                                @error('telefono_contacto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo contacto --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Correo <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="correo_contacto"
                                       class="form-control @error('correo_contacto') is-invalid @enderror"
                                       value="{{ old('correo_contacto') }}"
                                       placeholder="correo@email.com">
                                @error('correo_contacto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Descripción de la incidencia <span class="text-danger">*</span></label>
                                <textarea name="descripcion"
                                          rows="4"
                                          class="form-control @error('descripcion') is-invalid @enderror"
                                          placeholder="Describe detalladamente el problema...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Dirección --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text"
                                       name="direccion"
                                       class="form-control"
                                       value="{{ old('direccion') }}"
                                       placeholder="Calle Mayor 1">
                            </div>

                            {{-- Población --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Población</label>
                                <input type="text"
                                       name="poblacion"
                                       class="form-control"
                                       value="{{ old('poblacion') }}"
                                       placeholder="Huelva">
                            </div>

                            {{-- Código postal --}}
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text"
                                       name="codigo_postal"
                                       class="form-control @error('codigo_postal') is-invalid @enderror"
                                       value="{{ old('codigo_postal') }}"
                                       placeholder="21001"
                                       maxlength="5">
                                @error('codigo_postal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Fecha realización --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha deseada de realización</label>
                                <input type="date"
                                       name="fecha_realizacion"
                                       class="form-control @error('fecha_realizacion') is-invalid @enderror"
                                       value="{{ old('fecha_realizacion') }}">
                                @error('fecha_realizacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Anotaciones --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Anotaciones adicionales</label>
                                <textarea name="anotaciones_previas"
                                          rows="3"
                                          class="form-control"
                                          placeholder="Cualquier información adicional...">{{ old('anotaciones_previas') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('incidencia.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-paper-plane me-1"></i> Enviar Incidencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @endif

    </div>
</div>
@endsection