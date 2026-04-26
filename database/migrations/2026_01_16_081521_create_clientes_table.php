<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de clientes.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Datos identificativos
            $table->string('cif', 20)->unique();
            $table->string('nombre', 150);
            $table->string('telefono', 30);
            $table->string('correo', 150);
            $table->string('cuenta_corriente', 50)->nullable();

            // País y moneda
            $table->string('pais', 100)->nullable();
            $table->string('moneda', 10)->nullable();

            // Cuota mensual que se le cobra
            $table->decimal('importe_cuota', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla clientes.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};