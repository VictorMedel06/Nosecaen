<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $cuota->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .cabecera {
            width: 100%;
            margin-bottom: 30px;
        }

        .empresa {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a2e;
        }

        .empresa-datos {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .factura-titulo {
            text-align: right;
            font-size: 28px;
            font-weight: bold;
            color: #1a1a2e;
        }

        .factura-numero {
            text-align: right;
            font-size: 13px;
            color: #666;
        }

        .separador {
            border: none;
            border-top: 2px solid #1a1a2e;
            margin: 20px 0;
        }

        .seccion {
            width: 100%;
            margin-bottom: 25px;
        }

        .seccion-titulo {
            font-size: 12px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .cliente-nombre {
            font-size: 16px;
            font-weight: bold;
        }

        .cliente-datos {
            font-size: 13px;
            color: #444;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead tr {
            background-color: #1a1a2e;
            color: white;
        }

        table thead th {
            padding: 10px;
            text-align: left;
            font-size: 13px;
        }

        table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        table tbody td {
            padding: 10px;
            font-size: 13px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-seccion {
            width: 100%;
            margin-top: 20px;
        }

        .total-caja {
            background-color: #1a1a2e;
            color: white;
            padding: 12px 15px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .estado-pagada {
            color: green;
            font-weight: bold;
        }

        .estado-pendiente {
            color: red;
            font-weight: bold;
        }

        .pie {
            margin-top: 40px;
            font-size: 11px;
            color: #999;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    {{-- CABECERA --}}
    <table class="cabecera">
        <tr>
            <td style="width: 60%">
                <div class="empresa">Nosecaen S.L.</div>
                <div class="empresa-datos">
                    Empresa de Mantenimiento de Ascensores<br>
                    CIF: B00000000<br>
                    Calle Principal 1, Huelva<br>
                    Tel: 959 000 000 | info@nosecaen.com
                </div>
            </td>
            <td style="width: 40%; text-align: right;">
                <div class="factura-titulo">FACTURA</div>
                <div class="factura-numero">
                    Nº: {{ str_pad($cuota->id, 6, '0', STR_PAD_LEFT) }}<br>
                    Fecha: {{ now()->format('d/m/Y') }}<br>
                    Emisión: {{ $cuota->fecha_emision->format('d/m/Y') }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="separador">

    {{-- DATOS DEL CLIENTE --}}
    <div class="seccion">
        <div class="seccion-titulo">Facturar a:</div>
        <div class="cliente-nombre">{{ $cuota->cliente?->nombre ?? '-' }}</div>
        <div class="cliente-datos">
            CIF: {{ $cuota->cliente?->cif ?? '-' }}<br>
            Tel: {{ $cuota->cliente?->telefono ?? '-' }}<br>
            Email: {{ $cuota->cliente?->correo ?? '-' }}<br>
            País: {{ $cuota->cliente?->pais ?? '-' }}
        </div>
    </div>

    {{-- TABLA DE CONCEPTOS --}}
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Fecha Emisión</th>
                <th>Moneda</th>
                <th style="text-align: right;">Importe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $cuota->concepto }}</td>
                <td>{{ $cuota->fecha_emision->format('d/m/Y') }}</td>
                <td>{{ $cuota->cliente?->moneda ?? 'EUR' }}</td>
                <td style="text-align: right;">
                    {{ number_format($cuota->importe, 2) }}
                    {{ $cuota->cliente?->moneda ?? 'EUR' }}
                </td>
            </tr>
            @if($cuota->notas)
            <tr>
                <td colspan="4" style="color: #666; font-size: 12px;">
                    <em>Nota: {{ $cuota->notas }}</em>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- TOTAL --}}
    <table class="total-seccion">
        <tr>
            <td style="width: 60%">
                <strong>Estado:</strong>
                @if($cuota->pagada)
                    <span class="estado-pagada">
                        ✓ PAGADA el {{ $cuota->fecha_pago?->format('d/m/Y') }}
                    </span>
                @else
                    <span class="estado-pendiente">✗ PENDIENTE DE PAGO</span>
                @endif
            </td>
            <td style="width: 40%">
                <div class="total-caja">
                    TOTAL: {{ number_format($cuota->importe, 2) }}
                    {{ $cuota->cliente?->moneda ?? 'EUR' }}
                </div>
            </td>
        </tr>
    </table>

    {{-- PIE --}}
    <div class="pie">
        Nosecaen S.L. &mdash; CIF: B00000000 &mdash; Registro Mercantil de Huelva<br>
        Gracias por confiar en nuestros servicios.
    </div>

</body>
</html>