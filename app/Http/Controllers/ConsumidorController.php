<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;

class ConsumidorController extends Controller
{
    public function Post_RegCosumidor(Request $request){
        $accion = $request->accion;
        $id_consumidor = $request->id_consumidor;
        $username = $request->username;
        $Nombre = $request->nombre;
        $email = $request->email;
        // $password = $request->password;
        $edad = $request->edad;
        $id_tipo_estudio = $request->id_tipo_estudio;
        $estado = $request->estado;
        $resultado=0;

        $password   = Hash::make($request->password);

        $response = DB::connection('mysql')->select("call sp_mant_usuario_consumidor(?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_consumidor ,
            $username ,
            $Nombre,
            $email,
            $password,
            $edad,
            $id_tipo_estudio,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        $route = Route::getFacadeRoot()->current()->uri();
        if ($response->_error ==  -1) {
            return response_data([], 400, $message, $route);
        }

        $direcciones = $request->direcciones;
        $id_usuario = $response->_error;
        $resultado=0; 

        for ($i=0; $i < count($direcciones) ; $i++) {

            $direccion = $direcciones[$i]['direccion'];
            $latitude = $direcciones[$i]['latitude'];
            $longitude = $direcciones[$i]['longitude'];

            $response = DB::connection('mysql')->select("call sp_mant_direccion_usuario(?,?,?,?,?,?,?,?,?,?)", 
            [
                'I',            // accion
                null,           // id
                $id_usuario,    // usuario
                1,              // rol
                $direccion,     // direccion
                $longitude,     // longitude      
                $latitude,      // longitude  
                null,           // prioridad
                1,
                $resultado
            ]);

        }

        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            // $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        }        

        return response_data($response, 200, $message, $route);      
    }    
}
