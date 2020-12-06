<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Usuario;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header("Authorization", "");
        // $token = Str::substr($token, 7); // con esto quito el "Bearer "

        
        $usuario = Usuario::where("token", "=", $token)->where("rol", "=", "admin")->first();
        
        if ($usuario) {
            return $next($request);
        };
        
        
        return response()->json([
            'message' => 'Permisos insuficientes.',
        ], 403);
    }
}




