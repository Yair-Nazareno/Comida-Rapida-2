<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = auth('api')->user();

        if (!$user || !in_array($user->role, $roles)) {
            return response()->json([
                'message' => 'No tienes permiso para realizar esta acción.'
            ], 403);
        }

        return $next($request);
    }
}
