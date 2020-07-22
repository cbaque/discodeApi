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
        $subject = "Solicitud de cotización";
        $for = config('mail.username');
        //var_dump(config('mail.username'));//usa postman porfa para versi sale algun error
        try
        {
            Mail::send('email',$request->all(), function($msj) use($subject,$for,$request){
                $msj->from( config('mail.username'),"Discode web");
                $msj->subject($subject);
                $msj->to($for);
                $msj->cc($request->user_details['email']);
            });

            return true;
        } catch (\Exception $e) {
            var_dump( $e->getMessage() );
            return false;
        }
    }
}
