@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa fa-clipboard me-2"></i>Detalle de Tarea</h2>
    <div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.tareas.edit', $tarea) }}" class="btn btn-warning me-2">
                <i class="fa fa-edit me-1"></i> Editar
            </a>
            <a href="{{ route('admin.tareas.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Volver
            </a>
        @else
            <a href="{{ route('operario.tareas.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Volver
            </a>
        @endif
    </div>
</div>

{{-- Datos generales --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <i class="fa fa-info-circle me-2"></i>Datos de la Tarea
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-2">
                <strong>Cliente:</strong><br>
                {{ $tarea->cliente?->nombre ?? '-' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Operario asignado:</strong><br>
                {{ $tarea->operario?->nombre ?? 'Sin asignar' }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Persona de contacto:</strong><br>
                {{ $tarea->persona_contacto }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Teléfono:</strong><br>
                {{ $tarea->telefono_contacto }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Correo:</strong><br>
                {{ $tarea->correo_contacto }}
            </div>
            <div class="col-md-8 mb-2">
                <strong>Dirección:</strong><br>
                {{ $tarea->direccion ?? '-' }}, {{ $tarea->poblacion ?? '' }} {{ $tarea->codigo_postal ?? '' }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Estado:</strong><br>
                @if($tarea->estado === 'P')
                    <span class="badge bg-warning text-dark fs-6">Pendiente</span>
                @elseif($tarea->estado === 'R')
                    <span class="badge bg-success fs-6">Realizada</span>
                @else
                    <span class="badge bg-danger fs-6">Cancelada</span>
                @endif
            </div>
            <div class="col-md-4 mb-2">
                <strong>Fecha creación:</strong><br>
                {{ $tarea->fecha_creacion?->format('d/m/Y H:i') ?? '-' }}
            </div>
            <div class="col-md-4 mb-2">
                <strong>Fecha realización:</strong><br>
                {{ $tarea->fecha_realizacion?->format('d/m/Y') ?? '-' }}
            </div>
            <div class="col-md-12 mb-2">
                <strong>Descripción:</strong><br>
                {{ $tarea->descripcion }}
            </div>
        </div>
    </div>
</div>

{{-- Anotaciones --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-secondary text-white">
                <i class="fa fa-sticky-note me-2"></i>Anotaciones Previas
            </div>
            <div class="card-body">
                {{ $tarea->anotaciones_previas ?? 'Sin anotaciones previas.' }}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-secondary text-white">
                <i class="fa fa-sticky-note me-2"></i>Anotaciones Posteriores
            </div>
            <div class="card-body">
                {{ $tarea->anotaciones_posteriores ?? 'Sin anotaciones posteriores.' }}
            </div>
        </div>
    </div>
</div>

{{-- Operario: cambiar estado y anotaciones --}}
@if(auth()->user()->isOperario())
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="fa fa-tools me-2"></i>Actualizar Tarea
    </div>
    <div class="card-body">

        {{-- Cambiar estado --}}
        <form action="{{ route('operario.tareas.estado', $tarea) }}" method="POST" class="mb-4">
            @csrf
            @method('PATCH')
            <label class="form-label"><strong>Cambiar Estado</strong></label>
            <div class="d-flex gap-2">
                <select name="estado" class="form-select w-auto">
                    <option value="P" {{ $tarea->estado === 'P' ? 'selected' : '' }}>Pendiente</option>
                    <option value="R" {{ $tarea->estado === 'R' ? 'selected' : '' }}>Realizada</option>
                    <option value="C" {{ $tarea->estado === 'C' ? 'selected' : '' }}>Cancelada</option>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-1"></i> Actualizar Estado
                </button>
            </div>
        </form>

        {{-- Anotaciones posteriores --}}
        <form action="{{ route('operario.tareas.anotaciones', $tarea) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <label class="form-label"><strong>Anotaciones Posteriores</strong></label>
            <textarea name="anotaciones_posteriores" rows="4"
                      class="form-control mb-2 @error('anotaciones_posteriores') is-invalid @enderror"
                      placeholder="Describe el trabajo realizado...">{{ old('anotaciones_posteriores', $tarea->anotaciones_posteriores) }}</textarea>
            @error('anotaciones_posteriores')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label class="form-label mt-2"><strong>Fichero Resumen</strong></label>
            <input type="file" name="fichero_resumen" class="form-control mb-3">

            <button type="submit" class="btn btn-success">
                <i class="fa fa-save me-1"></i> Guardar Anotaciones
            </button>
        </form>
    </div>
</div>
@endif
@endsection