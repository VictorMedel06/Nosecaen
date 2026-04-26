<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de tareas/incidencias.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();

            // Cliente que encarga el trabajo
            $table->foreignId('cliente_id')
                  ->nullable()
                  ->constrained('clientes')
                  ->nullOnDelete();

            // Operario asignado (nullable porque el cliente puede crear sin asignar)
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Persona de contacto
            $table->string('persona_contacto', 150);
            $table->string('telefono_contacto', 30);
            $table->string('correo_contacto', 150);

            // Dirección donde se realiza el trabajo
            $table->string('direccion', 255)->nullable();
            $table->string('poblacion', 100)->nullable();
            $table->string('codigo_postal', 5)->nullable();
            $table->tinyInteger('provincia')->nullable();

            // Descripción de la tarea
            $table->string('titulo', 200)->nullable();
            $table->text('descripcion');

            // Estado: P=Pendiente, R=Realizada, C=Cancelada
            $table->enum('estado', ['P', 'R', 'C'])->default('P');

            // Fechas
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->date('fecha_realizacion')->nullable();

            // Anotaciones
            $table->text('anotaciones_previas')->nullable();
            $table->text('anotaciones_posteriores')->nullable();

            // Fichero adjunto que sube el operario
            $table->string('fichero_resumen', 255)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla tareas.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};