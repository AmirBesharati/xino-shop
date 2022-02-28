<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed quantity
 * @property mixed is_deleted
 * @property mixed status
 */
class Product extends Model
{
    const _STATUS_ACTIVE = 1;
    const _STATUS_DISABLE = 2;

    /**
     * @description : find and return product by global code
     */
    public static function findByCode($product_code)
    {
        return self::query()->where('display_code' , $product_code)->first();
    }


    /**
     * @description : this function check conditions when customer want to buy a product
     */
    public function invalid(): bool
    {
        if($this->is_deleted == 0) return false;
        if($this->quantity == 0) return false;
        if($this->status == 0) return false;
        return true;
    }


    /**
     * @description : this function check conditions when customer want to buy a product and if the conditions not true return a message
     */
    public function invalidMessage(): string
    {
        if($this->is_deleted == 0) return 'product not exists.';
        if($this->quantity == 0) return 'product quantity is finished.';
        if($this->status == 0) return 'product not exists.';
        return '';
    }

}
