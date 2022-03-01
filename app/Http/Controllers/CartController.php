<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Managers\CartManager;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add_to_cart(Request $request): \Illuminate\Http\JsonResponse
    {
        //check user logged in or not
        $user = $request->user('api');


        $count = $request->get('count');
        $product_id = $request->get('product_id');
//        $product_code = $request->get('code');

        //find product
        /** @var Product $product */
        $product = Product::find($product_id);
//        $product = Product::findByCode($product_code);

        //check product
        if($product == null){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , WebserviceResponse::_ERROR_PRODUCT_NOT_EXISTS);
            return response()->json($response);
        }

        //check product validity
        if($product->invalid()){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , $product->invalidMessage());
            return response()->json($response);
        }


        //get client from request (client has been set in middleware to have access all around project)
        $client = $request->client;


        //add product to cart based on user or token
        if($user == null){
            $is_added_to_cart = CartManager::addProductToCartByClient($product_id , $client , $count);
        }else{
            $is_added_to_cart = CartManager::addProductToCartByUser($product_id , $user , $count);
        }


        //return response based on is_added_to_cart boolean
        if(!$is_added_to_cart){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , WebserviceResponse::_ERROR_CART_ADD_ISSUE);
        }else{
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        }
        return  response()->json($response);
    }


    public function cart_items(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user('api');
        $client = $request->client;


        if($user != null){
            $cart_items = Cart::getCartByUser($user);
        }else{
            $cart_items = Cart::getCartByClient($client);
        }

        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        $response->content['cart_items'] = $cart_items;
        return response()->json($response);
    }

}
