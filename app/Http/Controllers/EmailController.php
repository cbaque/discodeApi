<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use JWT;
use DB;
use Route;
use Illuminate\Support\Facades\Hash;


/**
 * Class EmailController
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Post_Send(Request $request)
    {
        $route = Route::getFacadeRoot()->current()->uri();
        $mailSend = $this->sendMailQuotation($request);
        $message = ($mailSend) ? "Cotización enviada correctamente" : "Error al enviar correo de cotización";
        $status = ($mailSend) ? 200 : 500;

        return response_data($message, $status, $message, $route);
    }

    public function sendMailQuotation(Request $request)
    {
        $subject = "Cotización";
        $for = "emilys.beltran.1995@gmail.com";

        try
        {
            Mail::send('email',$request->all(), function($msj) use($subject,$for){
                $msj->from(env('MAIL_USERNAME'),"Discode web");
                $msj->subject($subject);
                $msj->to($for);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
