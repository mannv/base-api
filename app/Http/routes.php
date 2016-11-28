<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function (Dingo\Api\Routing\Router $api) {
    $api->group(['namespace' => 'App\Http\Controllers'], function($api){
        $api->get('/auth/login', 'AuthController@loginAction');
        $api->get('/user/detail/{id}', 'AuthController@detail');
    });

//    $api->get('demo2',function(){
//        return 'demo V1';
//    });
//
//    $api->get('demo', ['middleware' => ['api.auth'],function(){
//        return 'demo V1';
//    }]);

    $api->get('create', ['as' => 'index.create', 'uses' => 'App\Http\Controllers\ExampleController@index']);

});