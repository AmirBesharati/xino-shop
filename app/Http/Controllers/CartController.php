<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Managers\CartManager;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
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
}
