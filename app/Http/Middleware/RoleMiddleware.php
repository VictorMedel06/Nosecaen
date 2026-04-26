<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Maneja el acceso según el rol del usuario.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            abort(403);
        }

        $user = auth()->user();

        // Si el usuario no tiene el campo tipo aún, bloqueamos
        if (!$user || !isset($user->tipo)) {
            abort(403, 'Usuario sin rol asignado');
        }

        if ($user->tipo !== $role) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
