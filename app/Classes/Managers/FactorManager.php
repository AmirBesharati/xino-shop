<?php


namespace App\Classes\Managers;


use App\Models\Cart;
use App\Models\Client;
use App\Models\Factor;
use App\Models\FactorContent;
use App\Models\User;

class FactorManager
{
    public static function makeFactorByClient(Client $client , $success_callback , $error_callback )
    {
        $cart = Cart::getCartByClient($client);
        $factor_res = self::makeFactorByCart($cart , null , $client->id);
        if($factor_res->status == 'success'){
            return call_user_func($success_callback , $factor_res->message);
        }
        return call_user_func($error_callback , $factor_res->message);
    }

    public static function makeFactorByUser(User $user , $success_callback , $error_callback)
    {
        $cart = Cart::getCartByUser($user);
        $factor_res = self::makeFactorByCart($cart , $user->id , null);
        if($factor_res->status == 'error'){
            return call_user_func($success_callback , $factor_res->message);
        }
        return call_user_func($error_callback , $factor_res->message);
    }

    private static function makeFactorByCart($carts , $user_id , $client_id): \stdClass
    {

        $factor_res = new \stdClass();
        //return error if cart is empty
        if(count($carts) == 0){
            $factor_res->status = 'error';
            $factor_res->messages = 'cart is empty.';
            return  $factor_res;
        }

        //make factor
        $factor = new Factor();
        if($user_id == null){
            $factor->client_id = $client_id;
        }else{
            $factor->user_id = $user_id;
        }

        $factor_contents = [];
        /** @var Cart $cart */
        foreach ($carts as $cart){
            if($cart->product->invalid()){
                continue;
            }
            $factor_content = new FactorContent();
            $factor_content->factor_id = $factor->id;
            $factor_content->product_id = $cart->product_id;
            $factor_content->tmp_product_name = $cart->product->name;
            $factor_content->product_price = $cart->product->price;
            $factor_content->product_discount_price = $cart->product->price;
            $factor_contents[] = $factor_content;
        }
        $factor->factor_contents()->saveMany($factor_contents);
        $factor->calculate_prices();

        return $factor_res;
    }
}
