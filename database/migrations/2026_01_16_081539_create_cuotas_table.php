<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de cuotas.
     */
    public function up(): void
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();

            // Cliente al que pertenece la cuota
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->cascadeOnDelete();

            // Datos de la cuota
            $table->string('concepto', 255);
            $table->date('fecha_emision');
            $table->decimal('importe', 10, 2);

            // Pago
            $table->boolean('pagada')->default(false);
            $table->date('fecha_pago')->nullable();

            // Este campo es para el Problema 4 (conversión de moneda)
            // Lo dejamos ya preparado desde el principio
            $table->decimal('importe_euros', 10, 2)->nullable();

            // Notas adicionales
            $table->text('notas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla cuotas.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};