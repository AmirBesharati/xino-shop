<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed client_id
 * @property mixed user_id
 * @property mixed id
 * @property mixed full_price
 * @property mixed full_discount_price
 * @property mixed factor_contents
 * @property int|mixed status
 */
class Factor extends Model
{
    const _STATUS_FACTOR_CREATED_READY_TO_PAY = 0;
    const _STATUS_FACTOR_CREATED_READY_TO_PAY_LABEL = 'factor created ready to pay';

    const _STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE = 1;
    const _STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE_LABEL = 'factor payed waiting for admin to approve payment';

    const _STATUS_FACTOR_PAY_FAILED = 2;
    const _STATUS_FACTOR_PAY_FAILED_LABEL = 'factor pay failed';


    protected $hidden = ['status' , 'client_id' , 'user_id' , 'updated_at' , 'id'];


    public function factor_contents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(FactorContent::class , 'factor_id' , 'id');
    }


    public function calculate_prices()
    {
        $full_price = 0;
        $full_discount_price = 0;

        /** @var FactorContent $factor_content */
        foreach ($this->factor_contents as $factor_content){
            $full_price += $factor_content->product_price;
            $full_discount_price += $factor_content->product_discount_price;
        }

        $this->full_price = $full_price;
        $this->full_discount_price = $full_discount_price;
        $this->save();
    }
}
