<?php
/**
 * Created by PhpStorm.
 * User: Alip
 * Date: 1/24/2019
 * Time: 7:15 PM
 */

namespace App\Classes\Api;


class WebserviceResponse
{

    const _RESULT_OK = 200;
    const _RESULT_ERROR = 400;
    const _NOT_FOUND = 404;



    const _ERROR_PRODUCT_NOT_EXISTS = 'product not exists';
    const _ERROR_CART_ADD_ISSUE = 'There are some problem during add to cart';
    const _ERROR_FACTOR_NOT_EXIST = 'factor not exist';


    var $content = [];
    var $meta = [];

    /**
     * WebserviceResponse constructor.
     * @param $result_code
     * @param null $result_message
     */
    public function __construct($result_code, $result_message = null)
    {

        if ($result_message == null) {
            $result_message = WebserviceResponse::get_result_fa_message($result_code);
        }

        $this->meta['resultCode'] = $result_code;
        $this->meta['resultMessage'] = $result_message;

    }

    public static function get_result_fa_message($code)
    {
        switch ($code) {
            case self::_RESULT_OK:
                return '';

            case self::_NOT_FOUND:
                return '';
        }
        return '';
    }

}
