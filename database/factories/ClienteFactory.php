<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para generar clientes de prueba.
 *
 * @author Victor
 * @version 1.0
 */
class ClienteFactory extends Factory
{
    /**
     * Define los datos de un cliente de prueba.
     */
    public function definition(): array
    {
        return [
            'cif'           => strtoupper($this->faker->bothify('?########')),
            'nombre'        => $this->faker->company(),
            'telefono'      => $this->faker->numerify('6########'),
            'correo'        => $this->faker->companyEmail(),
            'cuenta_corriente' => $this->faker->iban('ES'),
            'pais'          => 'España',
            'moneda'        => 'EUR',
            'importe_cuota' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}