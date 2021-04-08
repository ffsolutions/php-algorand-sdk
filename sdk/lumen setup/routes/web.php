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


use App\Http\Controllers\AlgodController;
use App\Http\Controllers\KmdController;
use App\Http\Controllers\IndexerController;


$router->get('/algod', 'AlgodController@index');
$router->get('/kmd', 'KmdController@index');
$router->get('/indexer', 'IndexerController@index');

#Simple Native Method Setup
$router->get('/', function () {
    echo "Access: /algod, /kmd or /indexer";
});
