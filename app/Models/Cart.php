<?php

namespace App\Models;

use Carbon\Carbon;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;

    protected $hidden = ['id' , 'product_id' , 'user_id' , 'client_id'];
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


    /**
     * @var User $user
     */
    public static function getCartByUser(User $user)
    {
        return self::query()
            ->where('user_id' , $user->id)
            ->with('product')
            ->get();
    }

    /**
     * @var Client $client
     */
    public static function getCartByClient(Client $client)
    {
        return self::query()
            ->where('client_id' , $client->id)
            ->with('product')
            ->get();
    }


    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Product::class , 'id' , 'product_id');
    }



}
