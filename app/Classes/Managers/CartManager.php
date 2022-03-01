<?php


namespace App\Classes\Managers;


use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class CartManager
{
    public static function addProductToCartByUser($product_id , $user , $count = 1): bool
    {
        try{
            $cart = Cart::findCartByProductIdUserId($product_id , $user->id);
            if($cart == null){
                //create new cart if not exists
                $cart = new Cart();
            }
            //update product count of cart if cart exists
            $cart->product_id = $product_id;
            $cart->user_id = $user->id;
            $cart->count = $count;
            $cart->save();
            return true;
        }catch (\Exception $exception){
//            log here if add to cart have an issue
            return false;
        }

    }

    public static function addProductToCartByClient($product_id , $client , $count = 1): bool
    {
        try{
            //find cart with same client id and product id
            $cart = Cart::findCartByProductIdClientId($product_id , $client->id);
            if($cart == null){
                //create new cart if not exists
                $cart = new Cart();
            }
            //update product count of cart if cart exists
            $cart->product_id = $product_id;
            $cart->client_id = $client->id;
            $cart->count = $count;
            $cart->save();
            return true;
        }catch (\Exception $exception){
//            log here if add to cart have an issue
            return false;
        }
    }
}
