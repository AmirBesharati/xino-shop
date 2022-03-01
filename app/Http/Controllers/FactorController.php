<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Managers\CartManager;
use App\Classes\Managers\FactorManager;
use App\Classes\QueryBuilders\FactorQueryBuilder;
use App\Models\Factor;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function make_factor(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user('api');
        $client = $request->client;


        //check user exists or not
        if ($user == null) {
            $response = FactorManager::makeFactorByClient($client, function ($success_messages, $factor) use ($client) {
                CartManager::emptyClientCart($client);

                $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK, $success_messages);
                $response->content['factor'] = $factor;
                return $response;

            }, function ($error_messages) {
                return new WebserviceResponse(WebserviceResponse::_RESULT_ERROR, $error_messages);
            });
        } else {
            $response = new \stdClass();
            FactorManager::makeFactorByUser($user, function ($success_messages, $factor) use ($user) {

                CartManager::emptyUserCart($user);

                $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK, $success_messages);
                $response->content['factor'] = $factor;
                return $response;

            }, function ($error_messages) {
                return new WebserviceResponse(WebserviceResponse::_RESULT_OK, $error_messages);
            });
        }

        return response()->json($response);

    }

    public function factor_list(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user('api');
        $client = $request->client;

        $factor_query_builder = new FactorQueryBuilder();
        $factor_query_builder->setStatuses([
            Factor::_STATUS_FACTOR_CREATED_READY_TO_PAY ,
            Factor::_STATUS_FACTOR_PAY_COMPLETED_PENDING_FOR_ADMIN_APPROVE ,
            Factor::_STATUS_FACTOR_PAY_FAILED
            //and u can manage which statuses load here (on request params or programmatically)
        ]);
        if($user == null){
            $factor_query_builder->setClientId($client->id);
        }else{
            $factor_query_builder->setUserId($client->id);
        }
        $factor_query_builder->setLoadFactorContents(true);
        $factors = $factor_query_builder->get_result();


        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        $response->content['factors'] = $factors;
        return response()->json($response);
    }
}
