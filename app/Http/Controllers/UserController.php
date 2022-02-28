<?php

namespace App\Http\Controllers;

use App\Classes\Api\WebserviceResponse;
use App\Classes\Traits\LoginValidationMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpseclib\Crypt\Hash;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

}
