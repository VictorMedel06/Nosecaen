<?php

use Illuminate\Database\Migrations\Migration;

// Esta tabla no se usa. Los datos de empleados están
// directamente en la tabla users.
return new class extends Migration
{
    public function up(): void
    {
        // Los campos de empleado se añaden en la migración
        // 2026_01_13_130644_add_employee_fields_to_users_table.php
    }

    public function down(): void
    {
        //
    }
};