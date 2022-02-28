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


        if($user == null){
            $cart_response = CartManager::addProductToCartByToken($product_id , $token);
        }else{
            $cart_response = CartManager::addProductToCartByUser($product_id , $user);
        }

    }
}
