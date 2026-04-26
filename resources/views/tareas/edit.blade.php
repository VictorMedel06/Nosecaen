@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-edit me-2"></i>Editar Tarea</h2>
    <a href="{{ route('admin.tareas.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.tareas.update', $tarea) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Cliente --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id"
                            class="form-select @error('cliente_id') is-invalid @enderror">
                        <option value="">-- Sin cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('cliente_id', $tarea->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Operario --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Operario <span class="text-danger">*</span></label>
                    <select name="user_id"
                            class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">-- Seleccionar operario --</option>
                        @foreach($operarios as $operario)
                            <option value="{{ $operario->id }}"
                                {{ old('user_id', $tarea->user_id) == $operario->id ? 'selected' : '' }}>
                                {{ $operario->nombre ?? $operario->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Persona contacto --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Persona de Contacto <span class="text-danger">*</span></label>
                    <input type="text"
                           name="persona_contacto"
                           class="form-control @error('persona_contacto') is-invalid @enderror"
                           value="{{ old('persona_contacto', $tarea->persona_contacto) }}">
                    @error('persona_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Teléfono contacto --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Teléfono Contacto <span class="text-danger">*</span></label>
                    <input type="text"
                           name="telefono_contacto"
                           class="form-control @error('telefono_contacto') is-invalid @enderror"
                           value="{{ old('telefono_contacto', $tarea->telefono_contacto) }}">
                    @error('telefono_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Correo contacto --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Correo Contacto <span class="text-danger">*</span></label>
                    <input type="email"
                           name="correo_contacto"
                           class="form-control @error('correo_contacto') is-invalid @enderror"
                           value="{{ old('correo_contacto', $tarea->correo_contacto) }}">
                    @error('correo_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" rows="3"
                              class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion', $tarea->descripcion) }}</textarea>
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
                           value="{{ old('direccion', $tarea->direccion) }}">
                </div>

                {{-- Población --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Población</label>
                    <input type="text"
                           name="poblacion"
                           class="form-control"
                           value="{{ old('poblacion', $tarea->poblacion) }}">
                </div>

                {{-- Código postal --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Código Postal</label>
                    <input type="text"
                           name="codigo_postal"
                           class="form-control @error('codigo_postal') is-invalid @enderror"
                           value="{{ old('codigo_postal', $tarea->codigo_postal) }}"
                           maxlength="5">
                    @error('codigo_postal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Estado --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                    <select name="estado"
                            class="form-select @error('estado') is-invalid @enderror">
                        <option value="P" {{ old('estado', $tarea->estado) === 'P' ? 'selected' : '' }}>Pendiente</option>
                        <option value="R" {{ old('estado', $tarea->estado) === 'R' ? 'selected' : '' }}>Realizada</option>
                        <option value="C" {{ old('estado', $tarea->estado) === 'C' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Fecha realización --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha de Realización</label>
                    <input type="date"
                           name="fecha_realizacion"
                           class="form-control @error('fecha_realizacion') is-invalid @enderror"
                           value="{{ old('fecha_realizacion', $tarea->fecha_realizacion?->format('Y-m-d')) }}">
                    @error('fecha_realizacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Anotaciones previas --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Anotaciones Previas</label>
                    <textarea name="anotaciones_previas" rows="3"
                              class="form-control">{{ old('anotaciones_previas', $tarea->anotaciones_previas) }}</textarea>
                </div>

                {{-- Fichero adjunto --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fichero Adjunto</label>
                    @if($tarea->fichero_resumen)
                        <p class="text-muted">
                            <i class="fa fa-file me-1"></i>
                            Ya tiene un fichero adjunto. Sube uno nuevo para reemplazarlo.
                        </p>
                    @endif
                    <input type="file"
                           name="fichero_resumen"
                           class="form-control">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.tareas.index') }}" class="btn btn-secondary me-2">
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