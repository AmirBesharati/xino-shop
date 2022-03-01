<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;

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
/*        $token = Hash::make(uniqid('ClientToken-'));
        session('client-token' , $token);
        $request->clientToken = $token;*/

        return $next($request);
    }
}
