<p>Hola{{ $cuota->cliente?->nombre ? ' ' . $cuota->cliente->nombre : '' }},</p>

<p>Adjuntamos la factura correspondiente a la cuota <strong>#{{ $cuota->id }}</strong>.</p>

<p>
    Concepto: {{ $cuota->concepto }}<br>
    Fecha de emision: {{ $cuota->fecha_emision->format('d/m/Y') }}<br>
    Importe: {{ number_format($cuota->importe, 2) }} {{ $cuota->cliente?->moneda ?? 'EUR' }}
</p>

<p>Gracias por confiar en Nosecaen S.L.</p>
