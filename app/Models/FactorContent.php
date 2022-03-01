<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed factor_id
 * @property mixed product_id
 * @property mixed tmp_product_name
 * @property mixed product_price
 * @property mixed product_discount_price
 */
class FactorContent extends Model
{
    protected $hidden = ['id' , 'factor_id' , 'product_id' , 'created_at' , 'updated_at'];

    }
