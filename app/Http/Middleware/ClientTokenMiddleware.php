<?php

namespace App\Http\Middleware;

use App\Classes\Api\WebserviceResponse;
use Closure;
use Illuminate\Support\Facades\Hash;
use phpseclib\Crypt\Random;

class ClientTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('client-token');
        if($token == '' OR $token == null){
            $client_token = Hash::make(Random::string(20));
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , 'Client Token Is Invalid');
            $response->content['client_token'] = $client_token;
            return response()->json($response);
        }
        return $next($request);
    }
}
