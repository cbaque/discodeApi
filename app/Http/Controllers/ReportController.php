<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Route;

class ReportController extends Controller
{
    public function Get_ReportRecep($accion){
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_success');
        $response = DB::connection('mysql')->select("call sp_report_recepcion(?)", [
            $accion
        ]);
        return response_data($response, 200, $message, $route);        
        // return  $response;
    }
}
