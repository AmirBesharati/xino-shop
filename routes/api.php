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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test' , function (){
    \App\Models\User::query()->create([
       'name' => '' ,
       'email' => 'amirbesharati59@gmail.com' ,
       'password' => Hash::make('passpass') ,
    ]);
});


Route::get('/products' , [ProductController::class , 'products']);
Route::get('/product-detail' , [ProductController::class , 'product_detail']);


Route::post('/cart-items' , [CartController::class , 'cart_items']);
Route::post('/add-to-cart' , [CartController::class , 'add_to_cart']);


Route::post('/make-factor' , [FactorController::class , 'make_factor']);
Route::post('/do-pay' , [FactorController::class , 'make_factor']);


Route::prefix('auth')->group(function (){
    Route::post('/login' , [AuthController::class , 'login']);
});
