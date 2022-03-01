<?php


namespace App\Classes\Managers;


use App\Classes\Helpers\HashHelper;
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
            return call_user_func($success_callback , $factor_res->messages ,  $factor_res->body);
        }
        return call_user_func($error_callback , $factor_res->messages);
    }

    public static function makeFactorByUser(User $user , $success_callback , $error_callback)
    {
        $cart = Cart::getCartByUser($user);
        $factor_res = self::makeFactorByCart($cart , $user->id , null);
        if($factor_res->status == 'error'){
            return call_user_func($success_callback , $factor_res->messages , $factor_res->body);
        }
        return call_user_func($error_callback , $factor_res->messages);
    }

    private static function makeFactorByCart($carts , $user_id , $client_id): \stdClass
    {

        $factor_res = new \stdClass();
        $factor_res->messages = [];
        $factor_res->body = '';

        //return error if cart is empty
        if(count($carts) == 0){
            $factor_res->status = 'error';
            $factor_res->messages[] = 'cart is empty';
            return  $factor_res;
        }

        //make factor
        $factor = new Factor();
        $factor->status = Factor::_STATUS_FACTOR_CREATED_READY_TO_PAY;
        $factor->client_id = $client_id == null ? -1 : $client_id;
        $factor->user_id = $user_id== null ? -1 : $user_id;
        $factor->save();

        $factor->follow_up_code = self::makeUniqueFollowUpCode([$factor->created_at , $factor->user_id , $factor->client_id  , $factor->id]);


        $factor_contents = [];
        /** @var Cart $cart */
        foreach ($carts as $cart){
            if($cart->product->invalid()){
                $factor_res->messages[] = 'product '. $cart->product->name . ' is currently unavailable, its removed from your cart.';
                continue;
            }
            $factor_content = new FactorContent();
            $factor_content->factor_id = $factor->id;
            $factor_content->product_id = $cart->product_id;
            $factor_content->tmp_product_name = $cart->product->name;
            $factor_content->product_price = $cart->product->price;
            $factor_content->product_discount_price = $cart->product->discount_price;
            $factor_contents[] = $factor_content;
        }
        $factor->factor_contents()->saveMany($factor_contents);
        $factor->calculate_prices();

        $factor->load(['factor_contents']);

        $factor_res->status = 'success';
        $factor_res->body = $factor;
        return $factor_res;
    }

    private static function makeUniqueFollowUpCode($data)
    {
        return HashHelper::encryptArrayString($data);
    }
}
