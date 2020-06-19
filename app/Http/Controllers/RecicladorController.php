<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;

class RecicladorController extends Controller
{
    public function Post_RegReciclador(Request $request){

        $route = Route::getFacadeRoot()->current()->uri();

        $accion = $request->accion;
        $id_user_reciclador = $request->id_user_reciclador;
        $ruc_ci = $request->ruc_ci;
        $email = $request->email;
        // $password = $request->password;
        $edad = $request->edad;
        $telefono = $request->telefono;
        $id_sector = $request->id_sector;
        $direccion = $request->direccion;
        $asociacion = $request->asociado;
        // $longitud = $request->longitud;
        $longitud = '';
        // $latitud = $request->latitud;
        $latitud = '';
        // $nombre = $request->nombre;
        $nombre = $request->ruc_ci;
        $estado = $request->estado;
        $username = $request->username;

        $password   = Hash::make($request->password);

        $resultado=0;

        $response = DB::connection('mysql')->select("call sp_mant_usuario_reciclador(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_user_reciclador,
            $ruc_ci,
            $username,
            $email,
            $password,
            $edad,
            $telefono,
            $id_sector,
            $direccion,
            $asociacion,
            $longitud,
            $latitud,
            $nombre,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  -1) {
            // $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        }


        $productos = $request->productos;
        $id_usuario = $response->_error;
        $resultado=0;

        if ( count ( $productos ) > 0 ) {
            for ($i=0; $i < count($productos) ; $i++) {

                $id_producto = $productos[$i]['id_producto'];
                $response = DB::connection('mysql')->select("call sp_mant_produc_reci_recu(?,?,?,?,?,?,?)", 
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

    public function Get_RecicladorPorDiaHora( $dia, $hora ) {

        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_obtener_reciclador_diahora(?,?)", [
            $dia,
            $hora
        ]);
        return response_data($response, 200, $message, $route);            

    }


}
