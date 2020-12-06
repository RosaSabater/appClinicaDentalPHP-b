<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


use App\Models\Cita;
use App\Models\Usuario;

class CitaController extends Controller
{
    public function nuevaCita(Request $request)
    {
        $body = $request -> all();

        try {
            $nueva_cita = [
                "usuario_id" => $body['usuarioId'],
                "motivo" => $body['motivo']
            ];
            
            // Creo la cita
            $respuesta = Cita::create($nueva_cita);
            
            return response() -> json($respuesta);
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "nueva_cita_1"
                    ], 500);
        };
    }

    public function mostrarCitas($usuarioId)
    {
        try {
            $citas = Cita::where("usuario_id", "=", $usuarioId)-> select('id as _id', 'estado', 'created_at as fecha', 'usuario_id as UsuarioId', 'motivo')->get();
            return response() -> json($citas);

        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "mostrar_cita_1"
                    ], 500);
        }
    }
    
    public function cancelarCita($citaId)
    {
        try {
               
                // Busco la cita con la id recibida

            $cita = Cita::where("id", "=", $citaId) -> first();
                
            $cita-> estado = 'cancelada';
            $cita->save();

            return response() -> json([
                    "message" => 'Se ha cancelado la cita correctamente.',
                ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                        'error' => "no se encontro ningun resultado",
                        'errorCode' => "cancelar_cita_1"
                    ], 500);
        }
    }

    
}
