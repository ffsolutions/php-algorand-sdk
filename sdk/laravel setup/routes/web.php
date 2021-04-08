<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AlgodController;
use App\Http\Controllers\KmdController;
use App\Http\Controllers\IndexerController;


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

Route::get('/algod', [AlgodController::class, 'index']);
Route::get('/kmd', [KmdController::class, 'index']);
Route::get('/indexer', [IndexerController::class, 'index']);

Route::get('/', function () {
    echo "Access: /algod, /kmd or /indexer";
});
