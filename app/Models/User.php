<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo User - representa a los empleados de la empresa.
 * Los empleados pueden ser de tipo admin u operario.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $dni
 * @property string|null $nombre
 * @property string|null $telefono
 * @property string|null $direccion
 * @property \Illuminate\Support\Carbon|null $fecha_alta
 * @property string $tipo
 *
 * @author Victor
 * @version 1.0
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /** @var array Campos que se pueden rellenar masivamente */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
        'dni',
        'nombre',
        'telefono',
        'direccion',
        'fecha_alta',
    ];

    /** @var array Campos ocultos en arrays/JSON */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @var array Casting de tipos */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'fecha_alta'        => 'date',
        ];
    }

    /**
     * Un empleado (operario) tiene muchas tareas asignadas.
     */
    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'user_id');
    }

    /**
     * Comprueba si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        return $this->tipo === 'admin';
    }

    /**
     * Comprueba si el usuario es operario.
     */
    public function isOperario(): bool
    {
        return $this->tipo === 'operario';
    }
}
