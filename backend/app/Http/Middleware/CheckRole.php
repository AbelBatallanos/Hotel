<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        // $roles = implode("|", $roles);
        $userRol = $request->user()?->rol->nombre;
        if (empty($role)) {
            return $next($request);
        }
        $roles = collect($role)
            ->flatMap(fn($r) => explode('|', $r))
            ->map(fn($r) => trim($r))
            ->toArray();
        if (!$request->user() || !in_array($userRol, $roles)) {
            return response()->json(['message' => 'No tienes permisos para esta acción sssssss.'], 403);
        }
        return $next($request);
    }
}
