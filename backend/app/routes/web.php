<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

/** Registrando url para requisições de solictações */
Route::group(['prefix' => 'request'], function () use ($router) {
    $router->get('/{bairro?}/{page?}', 'RequestController@get');
    $router->post('/', 'RequestController@post');
    $router->post('/help', 'RequestController@registerHelp');
    $router->post('token', 'RequestController@registerToken');   
});

/** Registrando url para requisições de recursos */
Route::group(['prefix' => 'resource'], function () use ($router) {
    $router->post('/', 'ResourcesController@post');
});

/** Registrando url para requisições de recursos */
Route::group(['prefix' => 'token'], function () use ($router) {
    $router->get('/', 'TokenController@get');
    $router->get('register', 'TokenController@register');
    $router->post('/', 'TokenController@post');
});

/** Registrando url para requisições de solictações */
Route::group(['prefix' => 'unity'], function () use ($router) {
    $router->get('/', 'UnityController@get');
    $router->post('/', 'UnityController@insert');   
});

/** Carregar Empresas */
Route::group(['prefix' => 'business'], function () use ($router) {
    $router->get('/', 'BusinessController@get');
});