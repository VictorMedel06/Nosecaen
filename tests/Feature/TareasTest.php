<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Tarea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pruebas para la gestión de tareas.
 *
 * @author Victor
 * @version 1.0
 */
class TareasTest extends TestCase
{
    use RefreshDatabase;

    /**
     * El listado de tareas es accesible para admins.
     */
    public function test_admin_puede_ver_lista_tareas(): void
    {
        $admin = User::factory()->create(['tipo' => 'admin']);

        $response = $this->actingAs($admin)
                         ->get('/admin/tareas');

        $response->assertStatus(200);
    }

    /**
     * Un operario puede ver sus tareas.
     */
    public function test_operario_puede_ver_sus_tareas(): void
    {
        $operario = User::factory()->create(['tipo' => 'operario']);

        $response = $this->actingAs($operario)
                         ->get('/operario/tareas');

        $response->assertStatus(200);
    }

    /**
     * Un operario no puede acceder al panel de admin.
     */
    public function test_operario_no_puede_acceder_a_admin(): void
    {
        $operario = User::factory()->create(['tipo' => 'operario']);

        $response = $this->actingAs($operario)
                         ->get('/admin/tareas');

        $response->assertStatus(403);
    }

    /**
     * Un usuario sin login no puede ver las tareas.
     */
    public function test_usuario_sin_login_no_puede_ver_tareas(): void
    {
        $response = $this->get('/admin/tareas');

        $response->assertRedirect('/login');
    }

    /**
     * Un admin puede crear una tarea correctamente.
     */
    public function test_admin_puede_crear_tarea(): void
    {
        $admin    = User::factory()->create(['tipo' => 'admin']);
        $operario = User::factory()->create(['tipo' => 'operario']);
        $cliente  = Cliente::factory()->create();

        $response = $this->actingAs($admin)
                         ->post('/admin/tareas', [
                             'cliente_id'        => $cliente->id,
                             'user_id'           => $operario->id,
                             'persona_contacto'  => 'Juan García',
                             'telefono_contacto' => '600123456',
                             'correo_contacto'   => 'juan@test.com',
                             'descripcion'       => 'Revisión del ascensor',
                             'estado'            => 'P',
                             'fecha_realizacion' => now()->addDays(5)->format('Y-m-d'),
                         ]);

        $response->assertRedirect('/admin/tareas');
        $this->assertDatabaseHas('tareas', [
            'descripcion' => 'Revisión del ascensor',
        ]);
    }

    /**
     * No se puede crear una tarea sin descripción.
     */
    public function test_no_se_puede_crear_tarea_sin_descripcion(): void
    {
        $admin    = User::factory()->create(['tipo' => 'admin']);
        $operario = User::factory()->create(['tipo' => 'operario']);

        $response = $this->actingAs($admin)
                         ->post('/admin/tareas', [
                             'user_id'           => $operario->id,
                             'persona_contacto'  => 'Juan García',
                             'telefono_contacto' => '600123456',
                             'correo_contacto'   => 'juan@test.com',
                             'descripcion'       => '',
                             'estado'            => 'P',
                         ]);

        $response->assertSessionHasErrors(['descripcion']);
    }
}