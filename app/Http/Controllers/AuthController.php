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

class AuthController extends Controller
{
    /***************************************************************************** */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login','register']]);
    }
    /***************************************************************************** */
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $usuario = $request->user;
        $contrasenia = $request->password;
        $movil = $request->movil;

        $data = DB::connection('mysql')->select("call sp_login(?,?,?)", [
            $usuario,
            $contrasenia,
            $movil
        ]);

        $data = $data[0];

        $message = $data->_mensaje;

        if ($data->_error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 500, $message, $route);
        }

        $hash_contrasenia = $data->contrasenia;
        if ( !Hash::check( trim($contrasenia), $hash_contrasenia ) ) {
            $route = Route::getFacadeRoot()->current()->uri();
            $message = config('global.msg_nopassword');
            return response_data([], 500, $message, $route);            
        }        

        $user = new User();
        $user->id_usuario =  $data->id_usuario;
        $user->contrasenia =  $data->contrasenia;
        $user->username     =  $data->username;
        $user->email        =  $data->email;

        $token = JWTAuth::fromUser($user);

        $token = auth()->login($user);

        return $this->respondWithToken($token, $message);
    }

    public function register(Request $request)
    {
        $usuario = $request->user;
        $password = $request->password;
        $email = $request->email;
        $nombres = $request->nombres;


        $data = DB::connection('mysql')->select("call sp_registerUser(?,?,?,?)", [
            $usuario,
            $password,
            $email,
            $nombres,
        ]);

        $data = $data[0];

        $message = $data->mensaje;
        if ($data->error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        }

        $data = DB::connection('mysql')->select("call sp_login(?,?)", [
            $usuario,
            $password
        ]);

        $data = $data[0];
        $message = $data->mensaje;
        if ($data->error ==  1) {
            $route = Route::getFacadeRoot()->current()->uri();
            return response_data([], 401, $message, $route);
        }

        $user = new User();
        $user->id =  $data->id;
        $user->nombre =  $data->nombre;
        $user->username =  $data->username;
        $user->mail =  $data->mail;

        $token = JWTAuth::fromUser($user);

        // $token = auth()->claims(['authorities' => [
        //     'ROLE_USER', 
        //     'ROLE_USER2'
        // ]])->login($user);

        return $this->respondWithToken($token, $message);      
    }    
    /***************************************************************************** */
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        return response()->json(auth()->user());
        // return response_data( auth()->user() , 200, 'Ok',  Route::getFacadeRoot()->current()->uri()); 
    }
    /***************************************************************************** */
    public function payload()
    {
        return response()->json(auth()->payload());
    }
    /***************************************************************************** */
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {   
        $route = Route::getFacadeRoot()->current()->uri();
        $message = config('global.msg_logout');
        return response_data([], 200, $message, $route);
    }
    /***************************************************************************** */
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /***************************************************************************** */
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message)
    {
        $data = [
            'token' => $token,
            'user' => auth()->user()
        ];

        $message = ($message == 'OK') ? config('global.msg_login') : $message;
        $route = Route::getFacadeRoot()->current()->uri();
        return response_data($data, 200, $message, $route);
    }

}
