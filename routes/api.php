<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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




Route::get('/test' , function (Request $request){
    dd($request->clientToken , session('client-token'));

    \App\Models\User::query()->create([
       'name' => '' ,
       'email' => 'amirbesharati59@gmail.com' ,
       'password' => Hash::make('passpass') ,
    ]);
});


Route::post('/products' , [ProductController::class , 'products']);
Route::post('/product-detail' , [ProductController::class , 'product_detail']);


Route::post('/cart-items' , [CartController::class , 'cart_items']);
Route::post('/add-to-cart' , [CartController::class , 'add_to_cart']);


Route::prefix('factor')->group(function (){
    Route::post('/make' , [FactorController::class , 'make_factor']);
    Route::post('/pay' , [FactorController::class , 'pay_factor']);
    Route::post('/list' , [FactorController::class , 'factor_list']);

});


Route::prefix('auth')->group(function (){
    Route::post('/login' , [AuthController::class , 'login']);
});

Route::middleware('auth:api')->prefix('user')->group(function (){
    Route::post('/' , [\App\Http\Controllers\UserController::class , 'user']);
});
