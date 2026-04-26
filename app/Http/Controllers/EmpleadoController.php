<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de empleados.
 * Solo accesible por administradores.
 *
 * @author Victor
 * @version 1.0
 */
class EmpleadoController extends Controller
{
    /**
     * Muestra la lista de empleados.
     */
    public function index()
    {
        $empleados = User::orderBy('nombre')->get();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Muestra el formulario para crear un empleado nuevo.
     */
    public function create()
    {
        return view('empleados.create');
    }

    /**
     * Guarda un empleado nuevo en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni'        => 'required|string|max:12|unique:users,dni',
            'nombre'     => 'required|string|max:120',
            'email'      => 'required|email|max:150|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'telefono'   => 'nullable|string|max:30',
            'direccion'  => 'nullable|string|max:255',
            'fecha_alta' => 'nullable|date',
            'tipo'       => 'required|in:admin,operario',
        ]);

        User::create([
            'dni'        => $request->dni,
            'nombre'     => $request->nombre,
            'name'       => $request->nombre,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'telefono'   => $request->telefono,
            'direccion'  => $request->direccion,
            'fecha_alta' => $request->fecha_alta,
            'tipo'       => $request->tipo,
        ]);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Muestra los datos de un empleado.
     */
    public function show(User $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Muestra el formulario para editar un empleado.
     */
    public function edit(User $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    /**
     * Actualiza los datos de un empleado.
     */
    public function update(Request $request, User $empleado)
    {
        $request->validate([
            'dni'        => 'required|string|max:12|unique:users,dni,' . $empleado->id,
            'nombre'     => 'required|string|max:120',
            'email'      => 'required|email|max:150|unique:users,email,' . $empleado->id,
            'password'   => 'nullable|string|min:8|confirmed',
            'telefono'   => 'nullable|string|max:30',
            'direccion'  => 'nullable|string|max:255',
            'fecha_alta' => 'nullable|date',
            'tipo'       => 'required|in:admin,operario',
        ]);

        // Solo actualizamos la contraseña si se ha introducido una nueva
        $datos = [
            'dni'        => $request->dni,
            'nombre'     => $request->nombre,
            'name'       => $request->nombre,
            'email'      => $request->email,
            'telefono'   => $request->telefono,
            'direccion'  => $request->direccion,
            'fecha_alta' => $request->fecha_alta,
            'tipo'       => $request->tipo,
        ];

        if ($request->filled('password')) {
            $datos['password'] = bcrypt($request->password);
        }

        $empleado->update($datos);

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Elimina un empleado de la base de datos.
     */
    public function destroy(User $empleado)
    {
        // Evitar que el admin se borre a sí mismo
        if ($empleado->id === auth()->id()) {
            return redirect()->route('admin.empleados.index')
                             ->with('error', 'No puedes eliminarte a ti mismo.');
        }

        $empleado->delete();

        return redirect()->route('admin.empleados.index')
                         ->with('success', 'Empleado eliminado correctamente.');
    }
}