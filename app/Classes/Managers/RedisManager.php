<?php


namespace App\Classes\Managers;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class RedisManager
{
    const CLIENT = 'client:';


    public static function get($key)
    {
        $redis_status = config('database.redis.status');
//        $redis_status = false;

        $redis = null;
        if($redis_status){
            $redis = Redis::get($key);
        }
        return json_decode($redis);
    }

    public static function set($key , $value , $sec_expiration = 86400)
    {
        $redis_status = config('database.redis.status');
        if($redis_status){
             Redis::set($key , json_encode($value) , 'EX' , $sec_expiration);
        }
    }
}
