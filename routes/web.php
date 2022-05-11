<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HoldingsController;
use App\Http\Controllers\HomeController;



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
        return view('auth.login');
});

// Route::get('/index', function () {
//     return view('index');
// });


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'],function(){
    Route::resource('basket', BasketController::class);
    Route::resource('orders', OrderController::class);
    Route::post('orders/exitprice/{id?}', [OrderController::class,'exitPrice'])->name('oreder.exitprice');
    Route::resource('holdings', HoldingsController::class);
    Route::get('/data-details',[HoldingsController::class,'getData'])->name('holdings.data');
    // Route::get('/holding/orders',[HoldingsController::class,'getHoldings'])->name('holdingslist.data');
    Route::get('detailedorder', 'App\Http\Controllers\OrderController@getAllOrder')->name('basket.data');
});
