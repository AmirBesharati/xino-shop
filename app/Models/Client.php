<?php

namespace App\Models;

use App\Classes\Managers\RedisManager;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['token'];

    public $timestamps = false;

    public static function findOrCreateClient($token)
    {
        $client = self::findByToken($token);
        if($client == null){
            $client = self::query()->create([
               'token' => $token
            ])->save();
            RedisManager::set(RedisManager::CLIENT.$token , $client);
        }
        return $client;
    }


    private static function findByToken($token)
    {
        $client = RedisManager::get(RedisManager::CLIENT.$token);
        if($client == null){
            $client = self::query()->where('token' , $token)->first();
        }
        return $client;
    }



}
