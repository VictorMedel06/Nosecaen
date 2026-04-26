<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;

/**
 * API Controller para clientes.
 * Usado por Vue/Quasar para operaciones CRUD sin recargar página.
 *
 * @author Victor
 * @version 1.0
 */
class ClienteApiController extends Controller
{
    /**
     * Devuelve la lista de todos los clientes en JSON.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return response()->json($clientes);
    }

    /**
     * Guarda un cliente nuevo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cif'           => 'required|string|max:20|unique:clientes,cif',
            'nombre'        => 'required|string|max:150',
            'telefono'      => 'required|string|max:30',
            'correo'        => 'required|email|max:150',
            'cuenta_corriente' => 'nullable|string|max:50',
            'pais'          => 'nullable|string|max:100',
            'moneda'        => 'nullable|string|max:10',
            'importe_cuota' => 'required|numeric|min:0',
        ]);

        $cliente = Cliente::create($request->all());

        return response()->json($cliente, 201);
    }

    /**
     * Devuelve un cliente por su ID.
     */
    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    /**
     * Actualiza un cliente.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'cif'           => 'required|string|max:20|unique:clientes,cif,' . $cliente->id,
            'nombre'        => 'required|string|max:150',
            'telefono'      => 'required|string|max:30',
            'correo'        => 'required|email|max:150',
            'cuenta_corriente' => 'nullable|string|max:50',
            'pais'          => 'nullable|string|max:100',
            'moneda'        => 'nullable|string|max:10',
            'importe_cuota' => 'required|numeric|min:0',
        ]);

        $cliente->update($request->all());

        return response()->json($cliente);
    }

    /**
     * Elimina un cliente.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente.']);
    }
}