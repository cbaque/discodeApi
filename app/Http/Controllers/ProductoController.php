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

class ProductoController extends Controller
{


    public function Post_Create(Request $request)
    {

        // $user           = auth()->user();
        $route          = Route::getFacadeRoot()->current()->uri();
        $response       = 1;
        $message        = 'Producto Creado Correctamente';
        $status         = 500;

        $name         	= isset($request->name) ? $request->name : null;
        $price       	= isset($request->price) ? $request->price : null;
        $categoria     	= isset($request->categoria) ? $request->categoria : null;
        $subcategoria   = isset($request->subcategoria) ? $request->subcategoria : null;
        $cantidad       = isset($request->cantidad) ? $request->cantidad : null;
        // $fecha          = isset($request->fecha) ? new DateTime( $request->fecha ) : null;
        $description    = isset($request->description) ? $request->description : null;
        $images         = $request->image;

        DB::beginTransaction();
        try 
        {   

            $response = DB::connection('mysql')->select("call sp_productos(?,?,?,?,?,?)", [
                $name
                ,$price
                ,$description
                ,$categoria
                ,$subcategoria
                ,$cantidad
            ]);

            $producto_id = $response[0]->producto;            

            foreach ($images as $key => $value) {
                $img = $value['image'];
                $image_parts = explode(";base64,", $img);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]); 

                $file = uniqid() . '.'.$image_type;
                \Storage::disk('local')->put($file,  $image_base64 );


                $response = DB::connection('mysql')->update("call sp_productos_images(?,?)", [
                    $producto_id
                    ,$file
                ]);                
            }


            $status         = 200;
            $response       = 0;
            DB::commit();
        } catch (\Exception $e) {
            $message =  $e->getMessage();
            DB::rollback();
            // guardamos errores

            // DB::connection('mysql')->select("call sp_error(?,?,?)", 
            // [
            //     $user->id_usuario
            //     ,$user->username
            //     ,$message
            // ]);            

        }

        return response_data($message, $status, $message, $route);   
    }

    public function Get_ListaProductos(){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_get_productos()");
        return response_data($response, 200, $message, $route);
    }

    public function Get_ListaProductoImages($producto){

        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_get_produtos_images(?)", [ $producto ] );
        return response_data($response, 200, $message, $route);     

    }    


}
