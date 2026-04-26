<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Cuota - representa los cargos mensuales a los clientes.
 * Pueden ser cuotas mensuales normales o cargos excepcionales.
 *
 * @property int $id
 * @property int $cliente_id
 * @property string $concepto
 * @property \Illuminate\Support\Carbon $fecha_emision
 * @property string|float|int $importe
 * @property bool $pagada
 * @property \Illuminate\Support\Carbon|null $fecha_pago
 * @property string|float|int|null $importe_euros
 * @property string|null $notas
 * @property-read Cliente $cliente
 *
 * @author Victor
 * @version 1.0
 */
class Cuota extends Model
{
    use HasFactory;

    /** @var string Tabla asociada al modelo */
    protected $table = 'cuotas';

    /** @var array Campos que se pueden rellenar masivamente */
    protected $fillable = [
        'cliente_id',
        'concepto',
        'fecha_emision',
        'importe',
        'pagada',
        'fecha_pago',
        'importe_euros',
        'notas',
    ];

    /** @var array Casting de tipos */
    protected $casts = [
        'fecha_emision' => 'date',
        'fecha_pago'    => 'date',
        'importe'       => 'decimal:2',
        'importe_euros' => 'decimal:2',
        'pagada'        => 'boolean',
    ];

    /**
     * La cuota pertenece a un cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Marca la cuota como pagada con la fecha de hoy.
     */
    public function marcarComoPagada(): void
    {
        $this->update([
            'pagada'     => true,
            'fecha_pago' => now()->toDateString(),
        ]);
    }

    /**
     * Comprueba si la cuota está pagada.
     */
    public function isPagada(): bool
    {
        return $this->pagada === true;
    }
}
