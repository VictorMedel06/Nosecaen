<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Dashboards
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Operario\DashboardController as OperarioDashboard;

// CRUDs
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\TareaController;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard general
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    return $user->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('operario.dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('dashboard');

        // CRUDs completos
        Route::resource('clientes', ClienteController::class);
        Route::get('clientes-vue', function () {
            return view('clientes.vue');
        })->name('clientes.vue');
        Route::resource('empleados', EmpleadoController::class);
        Route::get('empleados-inertia', function () {
            return inertia('Empleados');
        })->name('empleados.inertia');
        Route::resource('tareas', TareaController::class);
        Route::resource('cuotas', CuotaController::class);

        // Remesa mensual
        Route::post('cuotas/remesa', [CuotaController::class, 'remesaMensual'])
            ->name('cuotas.remesa');

        // Marcar cuota como pagada
        Route::patch('cuotas/{cuota}/pagada', [CuotaController::class, 'marcarPagada'])
            ->name('cuotas.pagada');

        // Factura PDF de una cuota
        Route::get('cuotas/{cuota}/factura', [CuotaController::class, 'factura'])
            ->name('cuotas.factura');

        // API para Vue/Quasar
        Route::prefix('api')->name('api.')->group(function () {
            Route::apiResource('clientes', \App\Http\Controllers\Api\ClienteApiController::class);
            Route::apiResource('empleados', \App\Http\Controllers\Api\EmpleadoApiController::class);
        });
    });

/*
|--------------------------------------------------------------------------
| OPERARIO
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:operario'])
    ->prefix('operario')
    ->name('operario.')
    ->group(function () {

        Route::get('/dashboard', [OperarioDashboard::class, 'index'])
            ->name('dashboard');

        // Ver tareas asignadas
        Route::get('/tareas', [TareaController::class, 'index'])
            ->name('tareas.index');

        Route::get('/tareas/{tarea}', [TareaController::class, 'show'])
            ->name('tareas.show');

        // Cambiar estado
        Route::patch('/tareas/{tarea}/estado', [TareaController::class, 'updateEstado'])
            ->name('tareas.estado');

        // Anotaciones posteriores
        Route::patch('/tareas/{tarea}/anotaciones', [TareaController::class, 'updateAnotaciones'])
            ->name('tareas.anotaciones');
    });

/*
|--------------------------------------------------------------------------
| Perfil (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Registro de incidencias por clientes (sin login)
Route::get('/incidencia', [\App\Http\Controllers\IncidenciaClienteController::class, 'index'])
    ->name('incidencia.index');

Route::post('/incidencia/verificar', [\App\Http\Controllers\IncidenciaClienteController::class, 'verificar'])
    ->name('incidencia.verificar');

Route::post('/incidencia/store', [\App\Http\Controllers\IncidenciaClienteController::class, 'store'])
    ->name('incidencia.store');

require __DIR__ . '/auth.php';
