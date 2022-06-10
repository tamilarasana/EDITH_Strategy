<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HoldingsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\Webhook\WebhookController;
use App\Http\Controllers\Webhook\WebhookbasketController;
use App\Http\Controllers\AuthController;




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


Route::get('login', [AuthController::class, 'index'])->name('login');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'],function(){

//AuthController
Route::post('submit-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('registers');
Route::post('submit-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard']); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    // Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');

    Route::resource('basket', BasketController::class);
    Route::resource('webhook', WebhookbasketController::class);
    Route::resource('orders', OrderController::class);
    Route::post('orders/exitprice/{id?}', [OrderController::class,'exitOrder'])->name('oreder.exitprice');
    Route::resource('holdings', HoldingsController::class);
    
    Route::get('/data-details',[HoldingsController::class,'getData'])->name('holdings.data');
    // Route::get('/holding/orders',[HoldingsController::class,'getHoldings'])->name('holdingslist.data');
    Route::get('detailedorder', 'App\Http\Controllers\OrderController@getAllOrder')->name('basket.data');
    Route::get('hookdorder', 'App\Http\Controllers\OrderController@getAllWebhookOrder')->name('hookdata.data');
    Route::post('/data-autocomplete',[InstrumentController::class,'autocomplete'])->name('autocomplete');
    
    Route::get('dashboardData', 'App\Http\Controllers\HistoryController@getAllHistrory')->name('dashboard.data');
    
    Route::get('basketnames', 'App\Http\Controllers\HistoryController@getbasketName')->name('basketname.data');
    
    Route::resource('history', HistoryController::class);
    
});
