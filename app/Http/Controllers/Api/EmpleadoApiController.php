<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoApiController extends Controller
{
    public function index()
    {
        $empleados = User::orderBy('nombre')->get();

        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:12|unique:users,dni',
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'fecha_alta' => 'nullable|date',
            'tipo' => 'required|in:admin,operario',
        ]);

        $empleado = User::create([
            'dni' => $validated['dni'],
            'nombre' => $validated['nombre'],
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'fecha_alta' => $validated['fecha_alta'] ?? null,
            'tipo' => $validated['tipo'],
        ]);

        return response()->json($empleado, 201);
    }

    public function show(User $empleado)
    {
        return response()->json($empleado);
    }

    public function update(Request $request, User $empleado)
    {
        $validated = $request->validate([
            'dni' => 'required|string|max:12|unique:users,dni,' . $empleado->id,
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:150|unique:users,email,' . $empleado->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:255',
            'fecha_alta' => 'nullable|date',
            'tipo' => 'required|in:admin,operario',
        ]);

        $data = [
            'dni' => $validated['dni'],
            'nombre' => $validated['nombre'],
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'direccion' => $validated['direccion'] ?? null,
            'fecha_alta' => $validated['fecha_alta'] ?? null,
            'tipo' => $validated['tipo'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $empleado->update($data);

        return response()->json($empleado);
    }

    public function destroy(User $empleado)
    {
        if ($empleado->id === auth()->id()) {
            return response()->json(['message' => 'No puedes eliminarte a ti mismo.'], 422);
        }

        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado correctamente.']);
    }
}
