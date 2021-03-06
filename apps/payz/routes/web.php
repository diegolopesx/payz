<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('create', 'AuthController@create');
    $router->post('login', 'AuthController@login');
    $router->get('logout', 'AuthController@logout');
    $router->get('me', 'AuthController@me');
});

$router->group(['prefix' => 'transactions'], function () use ($router) {
    $router->post('create', 'TransactionsController@create');
    $router->get('index', 'TransactionsController@index');
});
