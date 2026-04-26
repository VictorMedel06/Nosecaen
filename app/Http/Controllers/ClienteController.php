<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de clientes.
 * Solo accesible por administradores.
 *
 * @author Victor
 * @version 1.0
 */
class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un cliente nuevo.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guarda un cliente nuevo en la base de datos.
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

        Cliente::create($request->all());

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Muestra los datos de un cliente.
     */
    public function show(Cliente $cliente)
    {
        $cliente->load(['tareas', 'cuotas']);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza los datos de un cliente.
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

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente de la base de datos.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.clientes.index')
                         ->with('success', 'Cliente eliminado correctamente.');
    }
}