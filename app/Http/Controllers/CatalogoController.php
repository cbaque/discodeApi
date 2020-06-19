<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;

class CatalogoController extends Controller
{
    public function __construct()
    {
    }


    public function Get_ListaGenerales($codigo){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_listas_generales(?)", [$codigo]);
        return response_data($response, 200, $message, $route);
    }



    public function PosDiaRecolec(Request $request){
        $accion = $request->accion;
        $id_dia_recoleccion = $request->id_dia_recoleccion;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_dia_recolec(?,?,?,?,?)", [
            $accion,
            $id_dia_recoleccion,
            $descripcion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosHoraRecolec(Request $request){
        $accion = $request->accion;
        $id_hora = $request->id_hora;
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_hora_recolec(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_hora,
            $hora_inicio,
            $hora_fin,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosDiaHoraRecolec(Request $request){
        $accion = $request->accion;
        $id_dia_hora = $request->id_dia_hora;
        $id_dia = $request->id_dia;
        $id_hora = $request->id_hora;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_dia_hora(?,?,?,?,?,?)", [
            $accion,
            $id_dia_hora,
            $id_dia,
            $id_hora,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosCupos(Request $request){
        $accion = $request->accion;
        $id_cupon = $request->id_cupon;
        $id_patrocionador = $request->id_patrocionador;
        $descripcion = $request->descripcion;
        $codigo_qr = $request->codigo_qr;
        $cantidad_maxima = $request->cantidad_maxima;
        $telfecha_caducidadefono = $request->fecha_caducidad;
        $usuario = $request->usuario;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_cupon(?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_cupon,
            $id_patrocionador,
            $descripcion,
            $codigo_qr,
            $cantidad_maxima,
            $telfecha_caducidadefono,
            $usuario,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosNivelEstudio(Request $request){
        $accion = $request->accion;
        $id_nivel_estudio = $request->id_nivel_estudio;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_nivel_estudio(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_nivel_estudio,
            $descripcion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosRoll(Request $request){
        $accion = $request->accion;
        $id_rol = $request->id_rol;
        $nombre = $request->nombre;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_roles(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
            $accion,
            $id_rol,
            $nombre,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosSector(Request $request){
        $accion = $request->accion;
        $id_sector = $request->id_sector;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_sector(?,?,?,?,?)", [
            $accion,
            $id_sector,
            $descripcion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosTipoEnvio(Request $request){
        $accion = $request->accion;
        $id_tipo_envio = $request->id_tipo_envio;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_tipo_envio(?,?,?,?,?)", [
            $accion,
            $id_tipo_envio,
            $descripcion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }  
    public function PosTipoPersona(Request $request){
        $accionaccionaccion = $request->accion;
        $id_tipo_persona = $request->id_tipo_persona;
        $descripcion = $request->descripcion;
        $estado = $request->estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_tipo_persona(?,?,?,?,?)", [
            $accionaccionaccion,
            $id_tipo_persona,
            $descripcion,
            $estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        if ($response->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        } 
        return $response[0];     
    }   
    public function Get_Catalogos($accion){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_obtener_catalogo(?)", [
            $accion
        ]);
        return response_data($response, 200, $message, $route);        
        // return  $response;
    }
    public function Get_Productos(){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("SELECT a.*, false as selected FROM productos a WHERE a.estado = 1");
        return response_data($response, 200, $message, $route);        
        // return  $response;
    }
    public function post_PesoTransaccion(Request $request){
        $C_accion = $request->C_accion;
        $I_id_registro_recepcion = $request->I_id_registro_recepcion;
        $I_id_producto = $request->I_id_producto;
        $I_cantidad = $request->I_cantidad;
        $I_id_unidad_peso = $request->I_id_unidad_peso;
        $I_id_recolecto = $request->I_id_recolecto;
        $I_id_consumidor = $request->I_id_consumidor;
        $D_fecha_recepcion = $request->D_fecha_recepcion;
        $I_id_usuario = $request->I_id_usuario;
        $B_estado = $request->B_estado;
        $resultado=0;
        $response = DB::connection('mysql')->select("call sp_mant_registro_recepcion(?,?,?,?,?,?,?,?,?,?,?)", [
            $C_accion,
            $I_id_registro_recepcion,
            $I_id_producto,
            $I_cantidad,
            $I_id_unidad_peso,
            $I_id_recolecto,
            $I_id_consumidor,
            $D_fecha_recepcion,
            $I_id_usuario,
            $B_estado,
            $resultado
        ]);
        $response = $response[0];
        $message = $response->_mensaje;
        $route = Route::getFacadeRoot()->current()->uri();
        if ($response->_error ==  1) {
            return response_data([], 401, $message, $route);
        } 
        return response_data($response, 200, $message, $route);        
    }          
      
}
