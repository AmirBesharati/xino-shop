<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Managers\FactorManager;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function make_factor(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user('api');
        $client = $request->client;


        //check user exists or not
        if ($user == null) {
            $response = FactorManager::makeFactorByClient($client, function ($success_messages, $factor) {
                $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK, $success_messages);
                $response->content['factor'] = $factor;
                return $response;
            }, function ($error_messages) {
                return new WebserviceResponse(WebserviceResponse::_RESULT_ERROR, $error_messages);
            });
        } else {
            $response = new \stdClass();
            FactorManager::makeFactorByUser($user, function ($success_messages, $factor) {
                $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK, $success_messages);
                $response->content['factor'] = $factor;
                return $response;
            }, function ($error_messages) {
                return new WebserviceResponse(WebserviceResponse::_RESULT_OK, $error_messages);
            });
        }

        return response()->json($response);

    }
}
