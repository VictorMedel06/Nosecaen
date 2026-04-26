<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo Tarea - representa las incidencias/órdenes de trabajo.
 * Pueden ser creadas por administradores o por clientes.
 *
 * @property int $id
 * @property int|null $cliente_id
 * @property int|null $user_id
 * @property string $persona_contacto
 * @property string $telefono_contacto
 * @property string $correo_contacto
 * @property string|null $direccion
 * @property string|null $poblacion
 * @property string|null $codigo_postal
 * @property int|null $provincia
 * @property string|null $titulo
 * @property string $descripcion
 * @property string $estado
 * @property \Illuminate\Support\Carbon $fecha_creacion
 * @property \Illuminate\Support\Carbon|null $fecha_realizacion
 * @property string|null $anotaciones_previas
 * @property string|null $anotaciones_posteriores
 * @property string|null $fichero_resumen
 * @property-read Cliente|null $cliente
 * @property-read User|null $operario
 *
 * @author Victor
 * @version 1.0
 */
class Tarea extends Model
{
    use HasFactory;

    /** @var string Tabla asociada al modelo */
    protected $table = 'tareas';

    /** @var array Campos que se pueden rellenar masivamente */
    protected $fillable = [
        'cliente_id',
        'user_id',
        'persona_contacto',
        'telefono_contacto',
        'correo_contacto',
        'direccion',
        'poblacion',
        'codigo_postal',
        'provincia',
        'titulo',
        'descripcion',
        'estado',
        'fecha_creacion',
        'fecha_realizacion',
        'anotaciones_previas',
        'anotaciones_posteriores',
        'fichero_resumen',
    ];

    /** @var array Casting de tipos */
    protected $casts = [
        'fecha_creacion'    => 'datetime',
        'fecha_realizacion' => 'date',
    ];

    /**
     * La tarea pertenece a un cliente.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * La tarea pertenece a un operario (user).
     */
    public function operario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Comprueba si la tarea está pendiente.
     */
    public function isPendiente(): bool
    {
        return $this->estado === 'P';
    }

    /**
     * Comprueba si la tarea está realizada.
     */
    public function isRealizada(): bool
    {
        return $this->estado === 'R';
    }

    /**
     * Comprueba si la tarea está cancelada.
     */
    public function isCancelada(): bool
    {
        return $this->estado === 'C';
    }

    /**
     * Devuelve el texto del estado en español.
     */
    public function getEstadoTexto(): string
    {
        return match($this->estado) {
            'P' => 'Pendiente',
            'R' => 'Realizada',
            'C' => 'Cancelada',
            default => 'Desconocido',
        };
    }
}
