<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function Get_ProductosCliente(){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = 'OK';

        $data = DB::connection('mysql')->select("call sp_get_productos()");

        $data = collect($data);
        $response = $data->groupBy('codigo_categoria');    

        // $response = [
        //     'resources' => $result,
        // ];            

        return response_data($response, 200, $message, $route);
    }

}
