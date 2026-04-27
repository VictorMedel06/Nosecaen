<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class EmpleadoApiController extends Controller
{
    private function hasUserColumn(string $column): bool
    {
        static $cache = [];

        if (!array_key_exists($column, $cache)) {
            $cache[$column] = Schema::hasColumn('users', $column);
        }

        return $cache[$column];
    }

    public function index()
    {
        $orderColumn = $this->hasUserColumn('nombre') ? 'nombre' : 'name';
        $empleados = User::orderBy($orderColumn)->get();

        return response()->json($empleados);
    }

    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($this->hasUserColumn('dni')) {
            $rules['dni'] = 'required|string|max:12|unique:users,dni';
        } else {
            $rules['dni'] = 'nullable|string|max:12';
        }

        if ($this->hasUserColumn('telefono')) {
            $rules['telefono'] = 'nullable|string|max:30';
        }

        if ($this->hasUserColumn('direccion')) {
            $rules['direccion'] = 'nullable|string|max:255';
        }

        if ($this->hasUserColumn('fecha_alta')) {
            $rules['fecha_alta'] = 'nullable|date';
        }

        if ($this->hasUserColumn('tipo')) {
            $rules['tipo'] = 'required|in:admin,operario';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ];

        if ($this->hasUserColumn('nombre')) {
            $data['nombre'] = $validated['nombre'];
        }

        if ($this->hasUserColumn('dni') && array_key_exists('dni', $validated)) {
            $data['dni'] = $validated['dni'];
        }

        if ($this->hasUserColumn('telefono')) {
            $data['telefono'] = $validated['telefono'] ?? null;
        }

        if ($this->hasUserColumn('direccion')) {
            $data['direccion'] = $validated['direccion'] ?? null;
        }

        if ($this->hasUserColumn('fecha_alta')) {
            $data['fecha_alta'] = $validated['fecha_alta'] ?? null;
        }

        if ($this->hasUserColumn('tipo')) {
            $data['tipo'] = $validated['tipo'];
        }

        $empleado = User::create($data);

        return response()->json($empleado, 201);
    }

    public function show(User $empleado)
    {
        return response()->json($empleado);
    }

    public function update(Request $request, User $empleado)
    {
        $rules = [
            'nombre' => 'required|string|max:120',
            'email' => 'required|email|max:150|unique:users,email,' . $empleado->id,
            'password' => 'nullable|string|min:8|confirmed',
        ];

        if ($this->hasUserColumn('dni')) {
            $rules['dni'] = 'required|string|max:12|unique:users,dni,' . $empleado->id;
        } else {
            $rules['dni'] = 'nullable|string|max:12';
        }

        if ($this->hasUserColumn('telefono')) {
            $rules['telefono'] = 'nullable|string|max:30';
        }

        if ($this->hasUserColumn('direccion')) {
            $rules['direccion'] = 'nullable|string|max:255';
        }

        if ($this->hasUserColumn('fecha_alta')) {
            $rules['fecha_alta'] = 'nullable|date';
        }

        if ($this->hasUserColumn('tipo')) {
            $rules['tipo'] = 'required|in:admin,operario';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['nombre'],
            'email' => $validated['email'],
        ];

        if ($this->hasUserColumn('nombre')) {
            $data['nombre'] = $validated['nombre'];
        }

        if ($this->hasUserColumn('dni') && array_key_exists('dni', $validated)) {
            $data['dni'] = $validated['dni'];
        }

        if ($this->hasUserColumn('telefono')) {
            $data['telefono'] = $validated['telefono'] ?? null;
        }

        if ($this->hasUserColumn('direccion')) {
            $data['direccion'] = $validated['direccion'] ?? null;
        }

        if ($this->hasUserColumn('fecha_alta')) {
            $data['fecha_alta'] = $validated['fecha_alta'] ?? null;
        }

        if ($this->hasUserColumn('tipo')) {
            $data['tipo'] = $validated['tipo'];
        }

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
