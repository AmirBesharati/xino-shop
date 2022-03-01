<?php


namespace App\Classes\Managers;



use Illuminate\Support\Facades\Hash;

class ClientTokenManager
{
    public static function fetchToken()
    {
        session('client-token' , Hash::make(uniqid('ClientToken-')));
    }
}
