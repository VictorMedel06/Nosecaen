<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Añade los campos de empleado a la tabla users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('dni', 12)->unique()->nullable()->after('id');
            $table->string('nombre', 120)->nullable()->after('dni');
            $table->string('telefono', 30)->nullable()->after('email');
            $table->string('direccion', 255)->nullable()->after('telefono');
            $table->date('fecha_alta')->nullable()->after('direccion');
            $table->enum('tipo', ['operario', 'admin'])->default('operario')->after('fecha_alta');
        });
    }

    /**
     * Deshace los cambios.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['dni']);
            $table->dropColumn([
                'dni', 'nombre', 'telefono',
                'direccion', 'fecha_alta', 'tipo'
            ]);
        });
    }
};