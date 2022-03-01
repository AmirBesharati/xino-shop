<?php


namespace App\Classes\Managers;


use App\Models\Cart;
use App\Models\Client;
use App\Models\User;

class FactorManager
{
    public static function makeFactorByClient(Client $client , $success_callback , $error_callback )
    {
        $cart = Cart::getCartByClient($client);
        $factor_res = self::makeFactorByCart($cart);
        if($factor_res->status == 'success'){
            return call_user_func($success_callback , $factor_res->message);
        }
        return call_user_func($error_callback , $factor_res->message);
    }

    public static function makeFactorByUser(User $user , $success_callback , $error_callback)
    {
        $cart = Cart::getCartByUser($user);
        $factor_res = self::makeFactorByCart($cart);
        if($factor_res->status == 'error'){
            return call_user_func($success_callback , $factor_res->message);
        }
        return call_user_func($error_callback , $factor_res->message);
    }

    private static function makeFactorByCart($cart ): \stdClass
    {
        $factor_res = new \stdClass();

        $factor_res->status = 'error';
        $factor_res->message = 'cart is empty.';

        return $factor_res;
    }
}
