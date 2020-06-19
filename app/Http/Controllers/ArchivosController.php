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

class ArchivosController extends Controller
{

    public function Post_Images(Request $request){

    	$route = Route::getFacadeRoot()->current()->uri();
	    // $this->validate(request(),['image' => 'required|image|mimes:jpg,jpeg,png,gif' ]);

	    if (request()->hasFile('image')) {
	    	echo "bubu";
	        $file = request()->file('image');
	        $fileName = md5($file->getClientOriginalName(). time()) . "." . $file->getClientOriginalExtension();
	        $file->move('/home/redisime/public_html/images/', $fileName);  
	    }

		$data = [ 'imagen' => $fileName];  
		$message = 'Imagen cargada correctamente';

        // $image = $request->file('image');
        // $name = time().'.'.$image->getClientOriginalExtension();
        // $image->move('C:/Desarrollo/', $name);

        return response_data($data , 200, $message, $route);   
    }
}
