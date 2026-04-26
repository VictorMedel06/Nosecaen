<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo Cliente - representa a los clientes de la empresa.
 * Los clientes tienen cuotas mensuales y pueden registrar incidencias.
 *
 * @property int $id
 * @property string $cif
 * @property string $nombre
 * @property string $telefono
 * @property string $correo
 * @property string|null $cuenta_corriente
 * @property string|null $pais
 * @property string|null $moneda
 * @property string|float|int $importe_cuota
 *
 * @author Victor
 * @version 1.0
 */
class Cliente extends Model
{
    use HasFactory;

    /** @var string Tabla asociada al modelo */
    protected $table = 'clientes';

    /** @var array Campos que se pueden rellenar masivamente */
    protected $fillable = [
        'cif',
        'nombre',
        'telefono',
        'correo',
        'cuenta_corriente',
        'pais',
        'moneda',
        'importe_cuota',
    ];

    /** @var array Casting de tipos */
    protected $casts = [
        'importe_cuota' => 'decimal:2',
    ];

    /**
     * Un cliente tiene muchas tareas/incidencias.
     */
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class);
    }

    /**
     * Un cliente tiene muchas cuotas.
     */
    public function cuotas(): HasMany
    {
        return $this->hasMany(Cuota::class);
    }
}
