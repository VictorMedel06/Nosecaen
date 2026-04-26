<?php

namespace App\Http\Controllers;

use App\Models\Cuota;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de cuotas.
 * Solo accesible por administradores.
 *
 * @author Victor
 * @version 1.0
 */
class CuotaController extends Controller
{
    /**
     * Muestra la lista de cuotas.
     */
    public function index()
    {
        $cuotas = Cuota::with('cliente')
                       ->orderBy('fecha_emision', 'desc')
                       ->get();

        return view('cuotas.index', compact('cuotas'));
    }

    /**
     * Muestra el formulario para crear una cuota nueva.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cuotas.create', compact('clientes'));
    }

    /**
     * Guarda una cuota nueva en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id'    => 'required|exists:clientes,id',
            'concepto'      => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'importe'       => 'required|numeric|min:0',
            'pagada'        => 'nullable|boolean',
            'fecha_pago'    => 'nullable|date',
            'notas'         => 'nullable|string',
        ]);

        Cuota::create([
            'cliente_id'    => $request->cliente_id,
            'concepto'      => $request->concepto,
            'fecha_emision' => $request->fecha_emision,
            'importe'       => $request->importe,
            'pagada'        => $request->has('pagada'),
            'fecha_pago'    => $request->fecha_pago,
            'notas'         => $request->notas,
        ]);

        return redirect()->route('admin.cuotas.index')
                         ->with('success', 'Cuota creada correctamente.');
    }

    /**
     * Muestra los datos de una cuota.
     */
    public function show(Cuota $cuota)
    {
        $cuota->load('cliente');
        return view('cuotas.show', compact('cuota'));
    }

    /**
     * Muestra el formulario para editar una cuota.
     */
    public function edit(Cuota $cuota)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cuotas.edit', compact('cuota', 'clientes'));
    }

    /**
     * Actualiza los datos de una cuota.
     */
    public function update(Request $request, Cuota $cuota)
    {
        $request->validate([
            'cliente_id'    => 'required|exists:clientes,id',
            'concepto'      => 'required|string|max:255',
            'fecha_emision' => 'required|date',
            'importe'       => 'required|numeric|min:0',
            'pagada'        => 'nullable|boolean',
            'fecha_pago'    => 'nullable|date',
            'notas'         => 'nullable|string',
        ]);

        $cuota->update([
            'cliente_id'    => $request->cliente_id,
            'concepto'      => $request->concepto,
            'fecha_emision' => $request->fecha_emision,
            'importe'       => $request->importe,
            'pagada'        => $request->has('pagada'),
            'fecha_pago'    => $request->fecha_pago,
            'notas'         => $request->notas,
        ]);

        return redirect()->route('admin.cuotas.index')
                         ->with('success', 'Cuota actualizada correctamente.');
    }

    /**
     * Elimina una cuota de la base de datos.
     */
    public function destroy(Cuota $cuota)
    {
        $cuota->delete();

        return redirect()->route('admin.cuotas.index')
                         ->with('success', 'Cuota eliminada correctamente.');
    }

    /**
     * Marca una cuota como pagada.
     */
    public function marcarPagada(Cuota $cuota)
    {
        $cuota->marcarComoPagada();

        return back()->with('success', 'Cuota marcada como pagada.');
    }

    /**
     * Crea una cuota mensual para TODOS los clientes a la vez.
     * Esta es la operación de remesa mensual.
     */
    public function remesaMensual(Request $request)
    {
        $request->validate([
            'concepto'      => 'required|string|max:255',
            'fecha_emision' => 'required|date',
        ]);

        $clientes = Cliente::all();

        foreach ($clientes as $cliente) {
            Cuota::create([
                'cliente_id'    => $cliente->id,
                'concepto'      => $request->concepto,
                'fecha_emision' => $request->fecha_emision,
                'importe'       => $cliente->importe_cuota,
                'pagada'        => false,
            ]);
        }

        return redirect()->route('admin.cuotas.index')
                         ->with('success', 'Remesa mensual creada para ' . $clientes->count() . ' clientes.');
    }

    /**
     * Genera y descarga la factura en PDF de una cuota.
     */
    public function factura(Cuota $cuota)
    {
        $cuota->load('cliente');

        $pdf = Pdf::loadView('cuotas.factura', compact('cuota'));

        return $pdf->download('factura-' . $cuota->id . '.pdf');
    }
}
