<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;

class RecuperadorController extends Controller
{
    public function Post_RegRecuperado(Request $request){
        $route = Route::getFacadeRoot()->current()->uri();

        $accion = $request->accion;
        $id_recuperador = $request->id_recuperador;
        $ruc_ci = $request->ruc_ci;
        $id_tipo_persona = $request->id_tipo_persona;
        $username = $request->username;
        $email = $request->email;
        $password   = Hash::make($request->password);
        $telefono = $request->telefono;
        // $id_sector = $request->id_sector;
        $direccion = $request->direccion;
        $asociacion = $request->asociado;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_usuario_recuperador(?,?,?,?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_recuperador,
            $ruc_ci,
            $id_tipo_persona,
            $email,
            $username,
            $password,
            $telefono,
            null,
            $direccion,
            $asociacion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        print_r($response);
        $message = $response->_mensaje;
        if ($response->_error ==  -1) {
            return response_data([], 401, $message, $route);
        }

        $productos = $request->productos;
        $id_usuario = $response->_error;
        $resultado=0;

        if ( count ( $productos ) > 0 ) { 
            for ($i=0; $i < count($productos) ; $i++) {

                $id_producto = $productos[$i]['id_producto'];
                $response = DB::connection('mysql')->select("call sp_mant_produc_reci_recu2(?,?,?,?,?,?,?)", 
                [
                    'I',
                    null,
                    $id_usuario,
                    2,
                    $id_producto,
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
        }


        $dias = $request->dias; 
        $resultado=0; 

        if ( count ( $dias ) > 0 ) { 

            for ($i=0; $i < count($dias) ; $i++) {

                $id_dia = $dias[$i]['id_hora'];

                $hora_inicio = $dias[$i]['desde'];

                $hora_fin = $dias[$i]['hasta'];

                $response = DB::connection('mysql')->select("call sp_mant_hora_recolec(?,?,?,?,?,?,?,?)", 
                [
                    'I',
                    null,
                    $id_dia,
                    $id_usuario,
                    $hora_inicio,
                    $hora_fin,
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

        }


        $direcciones = $request->direcciones;
        $resultado=0; 

        if ( count ( $direcciones ) > 0 ) {
            for ($i=0; $i < count($direcciones) ; $i++) {

                // $direccion = $direcciones[$i]['direccion'];
                $latitude = $direcciones[$i]['latitude'];
                $longitude = $direcciones[$i]['longitude'];

                $response = DB::connection('mysql')->select("call sp_mant_direccion_usuario(?,?,?,?,?,?,?,?,?,?)", 
                [
                    'I',            // accion
                    null,           // id
                    $id_usuario,    // usuario
                    2,              // rol
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
        }



        return response_data($response, 200, $message, $route);  


    }  
}
