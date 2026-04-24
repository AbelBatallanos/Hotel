<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Loguear cualquier excepción
        $exceptions->report(function (Throwable $e) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                // "time" => $e->getdate,
            ]);
        });

        // Model not found → 404
        $exceptions->render(function (Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            return response()->json([
                'error' => 'Recurso no encontrado',
                'details' => $e->getMessage(),
            ], 404);
        });

        // Validación → 422
        $exceptions->render(function (Illuminate\Validation\ValidationException $e, $request) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $e->errors(),
            ], 422);
        });

        // Fallback → 500
        $exceptions->render(function (Throwable $e, $request) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'details' => $e->getMessage(),
            ], 500);
        });
    })->create();
