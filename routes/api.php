<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TickerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BasketController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tick', TickerController::class);
Route::put('pythonorder/{id}', 'App\Http\Controllers\OrderController@update');

Route::get('orders', 'App\Http\Controllers\TickerController@getOrder');
Route::get('detailedorder', 'App\Http\Controllers\OrderController@getAllOrder');

Route::resource('basket', BasketController::class);
// Route::post('basketUpdate',[BasketController::class, 'updateBasket']);
