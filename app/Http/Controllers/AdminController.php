<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cita;

class AdminController extends Controller
{
    public function mostrarUsuarios()
    {
        try {
            $usuarios = Usuario::all('id as _id', 'rol', 'nombre', 'apellidos', 'telefono', 'email', 'token');
            return response() -> json($usuarios);

        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "mostrar_usuarios_1"
                    ], 500);
        }
    }

    // $citas = Cita::select('citas.usuario_id as usuarioId', 'citas.id as idCita',' citas.motivo', 'citas.created_at as fecha', 'citas.estado')

    public function mostrarCitas(){

        try {
            $citas = Cita::join('usuarios', 'usuarios.id', '=', 'citas.usuario_id')
            ->select('usuarios.nombre', 'usuarios.apellidos', 'usuarios.telefono', 'usuarios.email', 'usuarios.rol', 'citas.estado', 'citas.id as _id', 'citas.created_at as fecha', 'citas.motivo')->get()->toarray();
            
            $response = array_map( function($cita) {
    
                $cita["datosUsuario"] = array(
                    "rol" => $cita["rol"],
                    "nombre" => $cita["nombre"],
                    "apellidos" => $cita["apellidos"],
                    "telefono" => $cita["telefono"],
                    "email" => $cita["email"],
                );
                
                unset($cita["rol"]);
                unset($cita["nombre"]);
                unset($cita["apellidos"]);
                unset($cita["telefono"]);
                unset($cita["email"]);
                
                return $cita;
                
            }, $citas);
            
            
            return response() -> json($response);
            
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "mostrar_citas_1"
                    ], 500);
        }
    }
}
