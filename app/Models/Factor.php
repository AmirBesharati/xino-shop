<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

/**
 * @property mixed client_id
 * @property mixed user_id
 * @property mixed id
 * @property mixed full_price
 * @property mixed full_discount_price
 * @property mixed factor_contents
 * @property int|mixed status
 * @property mixed follow_up_code
 * @property mixed created_at
 * @property mixed is_deleted
 */
class Factor extends Model
{
    const _STATUS_FACTOR_CREATED_READY_TO_PAY = 0;
    const _STATUS_FACTOR_CREATED_READY_TO_PAY_LABEL = 'factor created ready to pay';

    const _STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE = 1;
    const _STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE_LABEL = 'factor payed waiting for admin to approve payment';

    const _STATUS_FACTOR_PAY_FAILED = 2;
    const _STATUS_FACTOR_PAY_FAILED_LABEL = 'factor pay failed';


    const _FACTOR_STATUS_LABEL_ARRAY = [
        self::_STATUS_FACTOR_CREATED_READY_TO_PAY =>  self::_STATUS_FACTOR_CREATED_READY_TO_PAY_LABEL,
        self::_STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE =>  self::_STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE_LABEL,
        self::_STATUS_FACTOR_PAY_FAILED =>  self::_STATUS_FACTOR_PAY_FAILED_LABEL,
    ];


    protected $hidden = ['status' , 'is_deleted' , 'client_id' , 'user_id' , 'updated_at' , 'id'];

    protected $sh = ['created_at' , 'updated_at'];

    protected $appends = ['pay_price' , 'status_label'];

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
            $full_price += ($factor_content->product_price * $factor_content->count);
            $full_discount_price += ($factor_content->product_discount_price * $factor_content->count);
        }

        $this->full_price = $full_price;
        $this->full_discount_price = $full_discount_price;
        $this->save();
    }

    public function getStatusLabelAttribute(): string
    {
        return self::_FACTOR_STATUS_LABEL_ARRAY[$this->status];
    }

    public function getPayPriceAttribute()
    {
        return $this->full_price - $this->full_discount_price;
    }

    public function canPay(): bool
    {
        if($this->is_deleted == 1) return false;
        if($this->status != self::_STATUS_FACTOR_CREATED_READY_TO_PAY) return false;
        if(count($this->factor_contents) == 0) return false;
        return true;
    }

}
