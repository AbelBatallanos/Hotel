<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {

        $user =$request->user();
        if (!$user) {
            return response()->json(['error' => 'No autenticado.'], 401);
        }
        if(empty($types)){
            return $next($request);
        }

        if($user->es_admin){
            return $next($request);
        }
        
        foreach($types as $type){
            $column = "es_" . strtolower($type);

            if(isset($user->$column) && $user->$column){
                return $next($request);
            }
        }

        return response()->json([
            'error' => 'No tienes los permisos necesarios para acceder a este recurso.'
        ], 403);
    }
}
