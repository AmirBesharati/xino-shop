<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Traits\LoginValidationMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use LoginValidationMessage;

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $validator_rules = [
            'email' => 'required|exists:users,email' ,
            'password' => 'required'
        ];

        $validation = Validator::make($request->all() , $validator_rules , $this->loginMessageValidation());
        //check email validation
        if($validation->fails()){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , $validation->errors()->getMessages());
            return response()->json($response);
        }
        //check user email and password
        $user = User::query()->where('email' , $email)->first();

        //check user exists in database or not
        if(!$user){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , 'email/password is incorrect.');
            return response()->json($response);
        }


        //check password
        if(!Hash::check($password, $user->password)){
            $response = new WebserviceResponse(WebserviceResponse::_RESULT_ERROR , 'email/password is incorrect.');
            return response()->json($response);
        }

        $response = new WebserviceResponse(WebserviceResponse::_RESULT_OK);
        $response->content['token'] = $user->createToken('Laravel Passport Token')->accessToken;;
        return response()->json($response);
    }
}
