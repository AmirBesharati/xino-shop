<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;


    /**
     * @description return cart with same user_id and product_id
     */
    public static function findCartByProductIdUserId($product_id , $user_id)
    {
       return self::query()
           ->where('product_id' , $product_id)
           ->where('user_id' , $user_id)
           ->first();
    }

    /**
     * @description return cart with same client_id and product_id
     */
    public static function findCartByProductIdClientId($product_id , $client_id)
    {
        return self::query()
            ->where('product_id' , $product_id)
            ->where('client_id' , $client_id)
            ->first();
    }
}
