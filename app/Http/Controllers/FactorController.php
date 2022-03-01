<?php

namespace App\Http\Controllers;

use App\Classes\Managers\FactorManager;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function make_factor(Request $request)
    {
        $user = $request->user('api');
        $client = $request->client;

        //check user exists or not
        if($user == null){
            FactorManager::makeFactorByClient($client , function ($success_message){
                dd($success_message);
            } , function ($error_message){
                dd($error_message);
            });
        }else{
            FactorManager::makeFactorByUser($user , function ($success_message){
                dd($success_message);
            } , function ($error_message){
                dd($error_message);
            });
        }

    }
}
