<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use JWTAuth;
use JWT;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;
use DateTime;

class ReciclaController extends Controller
{


    public function Post_RegRecicla(Request $request)
    {

        $user           = auth()->user();
        $route          = Route::getFacadeRoot()->current()->uri();
        $response       = 1;
        $message        = 'Ok';
        $status         = 500;

        $accion         = isset($request->accion) ? $request->accion : null;
        $cabecera       = isset($request->cabecera) ? $request->cabecera : null;
        $reciclador     = isset($request->reciclador) ? $request->reciclador : null;
        $tipo_envio     = isset($request->tipo_envio) ? $request->tipo_envio : null;
        $total          = isset($request->total) ? $request->total : null;
        $fecha          = isset($request->fecha) ? new DateTime( $request->fecha ) : null;
        $hora           = isset($request->hora) ? new DateTime( $request->hora ) : null;
        $estado         = isset($request->estado) ? $request->estado : null;
        $cabecera_id    = 0;
        $productos      = $request->productos;
        $images         = $request->image;

        DB::beginTransaction();
        try 
        {

            $response = DB::connection('mysql')->select("call sp_mant_cabecera_tran(?,?,?,?,?,?,?,?,?)", [
                $accion
                ,$cabecera
                ,$user->id_usuario
                ,$reciclador
                ,$tipo_envio
                ,$total
                ,date_format($fecha, "Y-m-d")
                ,date_format($hora, "H:i:s")
                ,$user->id_usuario
            ]);       
            print_r( $response ) ;

            $cabecera_id    = $response[0]->id_cabecera;

            if ( count ( $productos ) > 0 ) { 

                for ($i=0; $i < count($productos) ; $i++) {

                    $id_producto = $productos[$i]['id_producto'];
                    $cantidad = $productos[$i]['cantidad'];

                    $response = DB::connection('mysql')->select("call sp_mant_detalle_tran(?,?,?,?,?,?)", 
                    [
                        $accion
                        ,null
                        ,$cabecera_id
                        ,$id_producto
                        ,$cantidad
                        ,$user->id_usuario
                    ]);

                }
            }

            $status         = 200;
            $response       = 0;
            DB::commit();
        } catch (\Exception $e) {
            $message =  $e->getMessage();
            DB::rollback();
            // guardamos errores

            DB::connection('mysql')->select("call sp_error(?,?,?)", 
            [
                $user->id_usuario
                ,$user->username
                ,$message
            ]);            

        }

        return response_data($response, $status, $message, $route);   
    }

}
