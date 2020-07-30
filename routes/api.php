<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'auth', 'middleware' => ['cors']
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});


Route::group([
    'prefix' => 'home', 'middleware' => 'cors'
], function () {
    Route::get('productos', 'HomeController@Get_ProductosCliente');
    Route::get('productos/images/{producto}', 'HomeController@Get_ProductosImages');
});


Route::group([
    'prefix' => 'catalogo', 'middleware' => ['cors']
], function () {
    Route::get('listasgenerales/{codigo}', 'CatalogoController@Get_ListaGenerales');
});


Route::group([
    'prefix' => 'archivos', 'middleware' => ['cors']
], function () {
    Route::post('upload', 'ArchivosController@Post_Images');
});


Route::group([
    'prefix' => 'producto', 'middleware' => ['cors']
], function () {
    Route::post('create', 'ProductoController@Post_Create');
    Route::post('edit', 'ProductoController@Post_Edit');
    Route::get('lista', 'ProductoController@Get_ListaProductos');
    Route::get('images/{producto}', 'ProductoController@Get_ListaProductoImages');
});

Route::group([
    'prefix' => 'email', 'middleware' => 'cors'
], function () {
    Route::post('send', 'EmailController@Post_Send');
});
