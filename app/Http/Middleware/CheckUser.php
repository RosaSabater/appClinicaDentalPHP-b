<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Usuario;


class CheckUser
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

        
        $usuario = Usuario::where("token", "=", $token)->first();
        
        if ($usuario) {
            return $next($request);
        };
        
        
        return response()->json([
            'message' => 'Token invalido.',
        ], 401);
    }
}
