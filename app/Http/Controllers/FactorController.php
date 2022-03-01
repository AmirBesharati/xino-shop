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

            } , function (){

            });
        }else{
            FactorManager::makeFactorByUser($user , function ($error_message){

            } , function (){

            });
        }

    }
}
