<?php


namespace App\Classes\Managers;


use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class CartManager
{
    public static function addProductToCartByUser($product_id , $user , $count = 1): bool
    {
        try{
            $cart = new Cart();
            $cart->product_id = $product_id;
            $cart->user_id = $user;
            $cart->count = $count;
            $cart->save();
            return true;
        }catch (\Exception $exception){
            //log here if add to cart have an issue
            return false;
        }

    }

    public static function addProductToCartByToken($product_id , $token , $count = 1): bool
    {
        try{
            $cart = new Cart();
            $cart->product_id = $product_id;
            $cart->client_id = $token;
            $cart->count = $count;
            $cart->save();
            return true;
        }catch (\Exception $exception){
            //log here if add to cart have an issue
            return false;
        }
    }
}
