<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\Cita;

class UsuarioController extends Controller
{
    public function nada (Request $request) {
          
        return response() -> json([
            "message" => "holi",
        ]);
    }

    public function registro(Request $request)
    {
        $body = $request -> all();
        
        try {

            // Encripto la contraseña
            $body['password'] = bcrypt($body["password"]);
                
            // Creo
            $body = Usuario::create($body);
                
                
            return response() -> json([
                "message" => "usuario creado",
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                    'error' => "El email ya existe.",
                    'errorCode' => "user_register_1"
                ], 500);
        };
    }
    
    
    
    public function login(Request $request)
    {
        $body = $request->all();
        
        $password = $body["password"];

        $usuario = Usuario::where('email', '=', $body["email"])
        -> first();


        // ¿He encontrado algo?
        if (is_null($usuario)) {
            return response() -> json([
                "errorCode" => "user_login_1",
                "error" => "Usuario no encontrado.",
            ], 401);
        } else {
            $password = $usuario -> password;
            
            
            // Compruebo la contraseña
            if (Hash::check($body["password"], $password)) {
                $usuario-> token = hash('sha256', Str::random(60));
                $usuario->save();
                
                $response = [
                    '_id' => $usuario -> id,
                    'nombre' => $usuario -> nombre,
                    'apellidos' => $usuario -> apellidos,
                    'telefono' => $usuario -> telefono,
                    'email' => $usuario -> email,
                    'rol' => $usuario -> rol,
                    'token' => $usuario -> token
                ];
                
                return response() -> json($response);
            };
        };
    }

    public function logout(Request $request)
    {
        $token = $request->header("Authorization", "");
        $usuario = Usuario::where('token', '=', $token)-> first();

        if ($usuario) {
            $usuario-> token = null;
            $usuario->save();

            return response()->json('Has cerrado sesion.', 200);
        } else {
            return response()->json('No se ha podido cerrar sesion', 500);
        };
    }

    public function baja(Request $request)
    {   
        try {
            $token = $request->header("Authorization", "");

            // obtengo el usuario con ese token
            $usuario = Usuario::where('token', '=', $token)-> first();

            // obtengo la id del usuario
            $id = $usuario['id'];

            // obtengo todas las citas de esa id y las borro
            Cita::where('usuario_id', '=', $id)->delete();

            // borro el usuario
            $usuario->delete();

            return response() -> json([
                "message" => 'Se ha eliminado la cuenta correctamente.',
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                    'message' => 'No se ha podido eliminar el usuario.'
            ], 500);
        };
    }
}
