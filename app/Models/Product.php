<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //find and return product by global code
    public static function findByCode($product_code)
    {
        return self::query()->where('display_code' , $product_code)->first();
    }
}
