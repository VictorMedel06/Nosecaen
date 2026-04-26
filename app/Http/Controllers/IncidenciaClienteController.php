<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Tarea;
use Illuminate\Http\Request;

/**
 * Controlador para el registro de incidencias por parte de clientes.
 * No requiere login. El cliente se identifica con CIF y teléfono.
 *
 * @author Victor
 * @version 1.0
 */
class IncidenciaClienteController extends Controller
{
    /**
     * Muestra el formulario de verificación de identidad.
     */
    public function index()
    {
        return view('incidencia.index');
    }

    /**
     * Verifica que el CIF y teléfono corresponden a un cliente registrado.
     */
    public function verificar(Request $request)
    {
        $request->validate([
            'cif'      => 'required|string',
            'telefono' => 'required|string',
        ]);

        // Buscamos el cliente por CIF y teléfono
        $cliente = Cliente::where('cif', $request->cif)
                          ->where('telefono', $request->telefono)
                          ->first();

        if (!$cliente) {
            return back()->withErrors([
                'cif' => 'No encontramos ningún cliente con ese CIF y teléfono.'
            ])->withInput();
        }

        // Guardamos el cliente en sesión para el siguiente paso
        session(['cliente_verificado_id' => $cliente->id]);

        return redirect()->route('incidencia.index')
                         ->with('cliente_id', $cliente->id)
                         ->with('cliente', $cliente);
    }

    /**
     * Guarda la incidencia registrada por el cliente.
     */
    public function store(Request $request)
    {
        // Comprobamos que el cliente está verificado
        $clienteId = session('cliente_verificado_id');

        if (!$clienteId) {
            return redirect()->route('incidencia.index')
                             ->withErrors(['error' => 'Debes verificar tu identidad primero.']);
        }

        $request->validate([
            'persona_contacto'  => 'required|string|max:150',
            'telefono_contacto' => 'required|string|max:30',
            'correo_contacto'   => 'required|email|max:150',
            'descripcion'       => 'required|string',
            'direccion'         => 'nullable|string|max:255',
            'poblacion'         => 'nullable|string|max:100',
            'codigo_postal'     => 'nullable|string|size:5|regex:/^\d{5}$/',
            'provincia'         => 'nullable|integer|min:1|max:52',
            'fecha_realizacion' => 'nullable|date|after:today',
            'anotaciones_previas' => 'nullable|string',
        ]);

        // Creamos la tarea sin operario asignado
        Tarea::create([
            'cliente_id'        => $clienteId,
            'user_id'           => null, // Sin operario, el admin lo asignará
            'persona_contacto'  => $request->persona_contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'correo_contacto'   => $request->correo_contacto,
            'descripcion'       => $request->descripcion,
            'direccion'         => $request->direccion,
            'poblacion'         => $request->poblacion,
            'codigo_postal'     => $request->codigo_postal,
            'provincia'         => $request->provincia,
            'estado'            => 'P',
            'fecha_realizacion' => $request->fecha_realizacion,
            'anotaciones_previas' => $request->anotaciones_previas,
        ]);

        // Limpiamos la sesión
        session()->forget('cliente_verificado_id');

        return redirect()->route('incidencia.index')
                         ->with('success', '¡Incidencia registrada correctamente! Un operario se pondrá en contacto contigo pronto.');
    }
}