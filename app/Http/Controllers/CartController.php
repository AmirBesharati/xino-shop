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
        $user = $request->user('passport');


        //check product exists
        $product_id = $request->get('product_id');
//        $product_code = $request->get('code');

        //find product
        /** @var Product $product */
        $product = Product::find($product_id);
//        $product = Product::findByCode($product_code);

        //check product validity
        if(!$product->invalid()){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , $product->invalidMessage());
            return response()->json($response);
        }


        //get client token
        $token = $request->token;


        //add product to cart based on user or token
        if($user == null){
            $is_added_to_cart = CartManager::addProductToCartByToken($product_id , $token);
        }
        $is_added_to_cart = CartManager::addProductToCartByUser($product_id , $user);


        //return response based on is_added_to_cart boolean
        if(!$is_added_to_cart){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR);
        }
        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        return  response()->json($response);
    }
}
