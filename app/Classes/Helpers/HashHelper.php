<?php


namespace App\Classes\Helpers;


class HashHelper
{
    static $pass_phrase = 'tradeBot';
    static $ciphering = 'AES-128-CTR';
    static $encryption_iv = '1234567891011121';

    public static function encryptArrayString($datas)
    {
        $pass_phrase = self::$pass_phrase;
        $ciphering = self::$ciphering;

        $encryption_iv = self::$encryption_iv;

        $data_string = '';
        foreach ($datas as $data){
            $data_string .= $data."-";
        }

        return openssl_encrypt($data_string, $ciphering , $pass_phrase , 0 , $encryption_iv);
    }


    public static function decryptArrayString($string)
    {
         return openssl_encrypt($string , self::$ciphering , self::$pass_phrase , 0 , self::$encryption_iv);
    }




}
