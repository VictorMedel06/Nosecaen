@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-plus me-2"></i>Nueva Tarea</h2>
    <a href="{{ route('admin.tareas.index') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left me-1"></i> Volver
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.tareas.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- Cliente --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id"
                            class="form-select @error('cliente_id') is-invalid @enderror">
                        <option value="">-- Sin cliente --</option>
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

                {{-- Operario --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Operario <span class="text-danger">*</span></label>
                    <select name="user_id"
                            class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">-- Seleccionar operario --</option>
                        @foreach($operarios as $operario)
                            <option value="{{ $operario->id }}"
                                {{ old('user_id') == $operario->id ? 'selected' : '' }}>
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
                           value="{{ old('persona_contacto') }}"
                           placeholder="Nombre y apellidos">
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
                           value="{{ old('telefono_contacto') }}"
                           placeholder="600 000 000">
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
                           value="{{ old('correo_contacto') }}"
                           placeholder="contacto@email.com">
                    @error('correo_contacto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div class="col-md-12 mb-3">
                    <label class="form-label">Descripción <span class="text-danger">*</span></label>
                    <textarea name="descripcion" rows="3"
                              class="form-control @error('descripcion') is-invalid @enderror"
                              placeholder="Descripción detallada de la tarea...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text"
                           name="direccion"
                           class="form-control @error('direccion') is-invalid @enderror"
                           value="{{ old('direccion') }}"
                           placeholder="Calle Mayor 1">
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Población --}}
                <div class="col-md-3 mb-3">
                    <label class="form-label">Población</label>
                    <input type="text"
                           name="poblacion"
                           class="form-control @error('poblacion') is-invalid @enderror"
                           value="{{ old('poblacion') }}"
                           placeholder="Huelva">
                    @error('poblacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                {{-- Provincia --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Provincia</label>
                    <select name="provincia"
                            class="form-select @error('provincia') is-invalid @enderror">
                        <option value="">-- Seleccionar --</option>
                        <option value="1" {{ old('provincia') == 1 ? 'selected' : '' }}>Álava</option>
                        <option value="2" {{ old('provincia') == 2 ? 'selected' : '' }}>Albacete</option>
                        <option value="3" {{ old('provincia') == 3 ? 'selected' : '' }}>Alicante</option>
                        <option value="4" {{ old('provincia') == 4 ? 'selected' : '' }}>Almería</option>
                        <option value="5" {{ old('provincia') == 5 ? 'selected' : '' }}>Ávila</option>
                        <option value="6" {{ old('provincia') == 6 ? 'selected' : '' }}>Badajoz</option>
                        <option value="7" {{ old('provincia') == 7 ? 'selected' : '' }}>Baleares</option>
                        <option value="8" {{ old('provincia') == 8 ? 'selected' : '' }}>Barcelona</option>
                        <option value="9" {{ old('provincia') == 9 ? 'selected' : '' }}>Burgos</option>
                        <option value="10" {{ old('provincia') == 10 ? 'selected' : '' }}>Cáceres</option>
                        <option value="11" {{ old('provincia') == 11 ? 'selected' : '' }}>Cádiz</option>
                        <option value="12" {{ old('provincia') == 12 ? 'selected' : '' }}>Castellón</option>
                        <option value="13" {{ old('provincia') == 13 ? 'selected' : '' }}>Ciudad Real</option>
                        <option value="14" {{ old('provincia') == 14 ? 'selected' : '' }}>Córdoba</option>
                        <option value="15" {{ old('provincia') == 15 ? 'selected' : '' }}>La Coruña</option>
                        <option value="16" {{ old('provincia') == 16 ? 'selected' : '' }}>Cuenca</option>
                        <option value="17" {{ old('provincia') == 17 ? 'selected' : '' }}>Girona</option>
                        <option value="18" {{ old('provincia') == 18 ? 'selected' : '' }}>Granada</option>
                        <option value="19" {{ old('provincia') == 19 ? 'selected' : '' }}>Guadalajara</option>
                        <option value="20" {{ old('provincia') == 20 ? 'selected' : '' }}>Guipúzcoa</option>
                        <option value="21" {{ old('provincia') == 21 ? 'selected' : '' }}>Huelva</option>
                        <option value="22" {{ old('provincia') == 22 ? 'selected' : '' }}>Huesca</option>
                        <option value="23" {{ old('provincia') == 23 ? 'selected' : '' }}>Jaén</option>
                        <option value="24" {{ old('provincia') == 24 ? 'selected' : '' }}>León</option>
                        <option value="25" {{ old('provincia') == 25 ? 'selected' : '' }}>Lleida</option>
                        <option value="26" {{ old('provincia') == 26 ? 'selected' : '' }}>La Rioja</option>
                        <option value="27" {{ old('provincia') == 27 ? 'selected' : '' }}>Lugo</option>
                        <option value="28" {{ old('provincia') == 28 ? 'selected' : '' }}>Madrid</option>
                        <option value="29" {{ old('provincia') == 29 ? 'selected' : '' }}>Málaga</option>
                        <option value="30" {{ old('provincia') == 30 ? 'selected' : '' }}>Murcia</option>
                        <option value="31" {{ old('provincia') == 31 ? 'selected' : '' }}>Navarra</option>
                        <option value="32" {{ old('provincia') == 32 ? 'selected' : '' }}>Ourense</option>
                        <option value="33" {{ old('provincia') == 33 ? 'selected' : '' }}>Asturias</option>
                        <option value="34" {{ old('provincia') == 34 ? 'selected' : '' }}>Palencia</option>
                        <option value="35" {{ old('provincia') == 35 ? 'selected' : '' }}>Las Palmas</option>
                        <option value="36" {{ old('provincia') == 36 ? 'selected' : '' }}>Pontevedra</option>
                        <option value="37" {{ old('provincia') == 37 ? 'selected' : '' }}>Salamanca</option>
                        <option value="38" {{ old('provincia') == 38 ? 'selected' : '' }}>Santa Cruz de Tenerife</option>
                        <option value="39" {{ old('provincia') == 39 ? 'selected' : '' }}>Cantabria</option>
                        <option value="40" {{ old('provincia') == 40 ? 'selected' : '' }}>Segovia</option>
                        <option value="41" {{ old('provincia') == 41 ? 'selected' : '' }}>Sevilla</option>
                        <option value="42" {{ old('provincia') == 42 ? 'selected' : '' }}>Soria</option>
                        <option value="43" {{ old('provincia') == 43 ? 'selected' : '' }}>Tarragona</option>
                        <option value="44" {{ old('provincia') == 44 ? 'selected' : '' }}>Teruel</option>
                        <option value="45" {{ old('provincia') == 45 ? 'selected' : '' }}>Toledo</option>
                        <option value="46" {{ old('provincia') == 46 ? 'selected' : '' }}>Valencia</option>
                        <option value="47" {{ old('provincia') == 47 ? 'selected' : '' }}>Valladolid</option>
                        <option value="48" {{ old('provincia') == 48 ? 'selected' : '' }}>Vizcaya</option>
                        <option value="49" {{ old('provincia') == 49 ? 'selected' : '' }}>Zamora</option>
                        <option value="50" {{ old('provincia') == 50 ? 'selected' : '' }}>Zaragoza</option>
                        <option value="51" {{ old('provincia') == 51 ? 'selected' : '' }}>Ceuta</option>
                        <option value="52" {{ old('provincia') == 52 ? 'selected' : '' }}>Melilla</option>
                    </select>
                    @error('provincia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Estado --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                    <select name="estado"
                            class="form-select @error('estado') is-invalid @enderror">
                        <option value="P" {{ old('estado') === 'P' ? 'selected' : '' }}>Pendiente</option>
                        <option value="R" {{ old('estado') === 'R' ? 'selected' : '' }}>Realizada</option>
                        <option value="C" {{ old('estado') === 'C' ? 'selected' : '' }}>Cancelada</option>
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
                           value="{{ old('fecha_realizacion') }}">
                    @error('fecha_realizacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Anotaciones previas --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Anotaciones Previas</label>
                    <textarea name="anotaciones_previas" rows="3"
                              class="form-control @error('anotaciones_previas') is-invalid @enderror"
                              placeholder="Indicaciones para el operario...">{{ old('anotaciones_previas') }}</textarea>
                    @error('anotaciones_previas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Fichero adjunto --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fichero Adjunto</label>
                    <input type="file"
                           name="fichero_resumen"
                           class="form-control @error('fichero_resumen') is-invalid @enderror">
                    <small class="text-muted">PDF, Word, imágenes...</small>
                    @error('fichero_resumen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.tareas.index') }}" class="btn btn-secondary me-2">
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Guardar Tarea
                </button>
            </div>
        </form>
    </div>
</div>
@endsection