<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador para la gestión de tareas/incidencias.
 * Los administradores pueden hacer todo.
 * Los operarios solo pueden ver sus tareas y actualizarlas.
 *
 * @author Victor
 * @version 1.0
 */
class TareaController extends Controller
{
    /**
     * Muestra la lista de tareas.
     * Admin ve todas, operario solo las suyas.
     */
    public function index()
    {
        if (request()->routeIs('admin.*')) {
            $tareas = Tarea::with(['cliente', 'operario'])
                           ->orderBy('fecha_creacion', 'desc')
                           ->get();
        } else {
            $tareas = Tarea::with(['cliente'])
                           ->where('user_id', Auth::id())
                           ->orderBy('fecha_creacion', 'desc')
                           ->get();
        }

        return view('tareas.index', compact('tareas'));
    }

    /**
     * Muestra el formulario para crear una tarea nueva.
     */
    public function create()
    {
        $clientes  = Cliente::orderBy('nombre')->get();
        $operarios = User::where('tipo', 'operario')->orderBy('nombre')->get();
        return view('tareas.create', compact('clientes', 'operarios'));
    }

    /**
     * Guarda una tarea nueva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'       => 'nullable|exists:clientes,id',
            'user_id'          => 'required|exists:users,id',
            'persona_contacto' => 'required|string|max:150',
            'telefono_contacto'=> 'required|string|max:30|regex:/^[\d\s\-\+\.]+$/',
            'correo_contacto'  => 'required|email|max:150',
            'descripcion'      => 'required|string',
            'direccion'        => 'nullable|string|max:255',
            'poblacion'        => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|size:5|regex:/^\d{5}$/',
            'provincia'        => 'nullable|integer|min:1|max:52',
            'titulo'           => 'nullable|string|max:200',
            'estado'           => 'required|in:P,R,C',
            'fecha_realizacion'=> 'nullable|date|after:today',
            'anotaciones_previas' => 'nullable|string',
        ]);

        // Gestión del fichero adjunto
        $fichero = null;
        if ($request->hasFile('fichero_resumen')) {
            $fichero = $request->file('fichero_resumen')
                               ->store('tareas', 'local');
        }

        Tarea::create([
            'cliente_id'        => $request->cliente_id,
            'user_id'           => $request->user_id,
            'persona_contacto'  => $request->persona_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'correo_contacto'   => $request->correo_contacto,
            'descripcion'       => $request->descripcion,
            'direccion'         => $request->direccion,
            'poblacion'         => $request->poblacion,
            'codigo_postal'     => $request->codigo_postal,
            'provincia'         => $request->provincia,
            'titulo'            => $request->titulo,
            'estado'            => $request->estado ?? 'P',
            'fecha_realizacion' => $request->fecha_realizacion,
            'anotaciones_previas' => $request->anotaciones_previas,
            'fichero_resumen'   => $fichero,
        ]);

        return redirect()->route('admin.tareas.index')
                         ->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Muestra los datos de una tarea.
     */
    public function show(Tarea $tarea)
    {
        $tarea->load(['cliente', 'operario']);
        return view('tareas.show', compact('tarea'));
    }

    /**
     * Muestra el formulario para editar una tarea.
     */
    public function edit(Tarea $tarea)
    {
        $clientes  = Cliente::orderBy('nombre')->get();
        $operarios = User::where('tipo', 'operario')->orderBy('nombre')->get();
        return view('tareas.edit', compact('tarea', 'clientes', 'operarios'));
    }

    /**
     * Actualiza los datos de una tarea.
     */
    public function update(Request $request, Tarea $tarea)
    {
        $request->validate([
            'cliente_id'       => 'nullable|exists:clientes,id',
            'user_id'          => 'required|exists:users,id',
            'persona_contacto' => 'required|string|max:150',
            'telefono_contacto'=> 'required|string|max:30|regex:/^[\d\s\-\+\.]+$/',
            'correo_contacto'  => 'required|email|max:150',
            'descripcion'      => 'required|string',
            'direccion'        => 'nullable|string|max:255',
            'poblacion'        => 'nullable|string|max:100',
            'codigo_postal'    => 'nullable|string|size:5|regex:/^\d{5}$/',
            'provincia'        => 'nullable|integer|min:1|max:52',
            'titulo'           => 'nullable|string|max:200',
            'estado'           => 'required|in:P,R,C',
            'fecha_realizacion'=> 'nullable|date|after:today',
            'anotaciones_previas' => 'nullable|string',
        ]);

        // Gestión del fichero adjunto
        if ($request->hasFile('fichero_resumen')) {
            // Borramos el fichero anterior si existe
            if ($tarea->fichero_resumen) {
                Storage::disk('local')->delete($tarea->fichero_resumen);
            }
            $tarea->fichero_resumen = $request->file('fichero_resumen')
                                              ->store('tareas', 'local');
        }

        $tarea->update([
            'cliente_id'        => $request->cliente_id,
            'user_id'           => $request->user_id,
            'persona_contacto'  => $request->persona_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'correo_contacto'   => $request->correo_contacto,
            'descripcion'       => $request->descripcion,
            'direccion'         => $request->direccion,
            'poblacion'         => $request->poblacion,
            'codigo_postal'     => $request->codigo_postal,
            'provincia'         => $request->provincia,
            'titulo'            => $request->titulo,
            'estado'            => $request->estado,
            'fecha_realizacion' => $request->fecha_realizacion,
            'anotaciones_previas' => $request->anotaciones_previas,
            'fichero_resumen'   => $tarea->fichero_resumen,
        ]);

        return redirect()->route('admin.tareas.index')
                         ->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Elimina una tarea de la base de datos.
     */
    public function destroy(Tarea $tarea)
    {
        // Borramos el fichero adjunto si existe
        if ($tarea->fichero_resumen) {
            Storage::disk('local')->delete($tarea->fichero_resumen);
        }

        $tarea->delete();

        return redirect()->route('admin.tareas.index')
                         ->with('success', 'Tarea eliminada correctamente.');
    }

    /**
     * Actualiza el estado de una tarea (usado por operarios).
     */
    public function updateEstado(Request $request, Tarea $tarea)
    {
        $request->validate([
            'estado' => 'required|in:P,R,C',
        ]);

        $tarea->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Actualiza las anotaciones posteriores (usado por operarios).
     */
    public function updateAnotaciones(Request $request, Tarea $tarea)
    {
        $request->validate([
            'anotaciones_posteriores' => 'required|string',
        ]);

        // El operario también puede subir un fichero resumen
        if ($request->hasFile('fichero_resumen')) {
            if ($tarea->fichero_resumen) {
                Storage::disk('local')->delete($tarea->fichero_resumen);
            }
            $tarea->fichero_resumen = $request->file('fichero_resumen')
                                              ->store('tareas', 'local');
        }

        $tarea->update([
            'anotaciones_posteriores' => $request->anotaciones_posteriores,
            'fichero_resumen'         => $tarea->fichero_resumen,
        ]);

        return back()->with('success', 'Anotaciones guardadas correctamente.');
    }
}