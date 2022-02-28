<?php


namespace App\Classes\Traits;

use Illuminate\Support\Facades\Validator;
use stdClass;

trait LoginValidationMessage
{

    public function loginMessageValidation(): array
    {
        return [
            'email.required' => 'email is required',
            'email.exists' => 'email not exists',
            'password.required' => 'password is required',
        ];
    }
}
