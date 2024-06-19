<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ExceptionArray;

trait ValidateRequestTrait
{
    public function ValidatorRequest($request, $validations, $message = null)
    {
        $validator = Validator::make($request, $validations);
        $message = $message ?: "Error de parametros";

        if ($validator->fails()) {
            throw new ExceptionArray($message, 400, $validator->errors()->all());
        }
    }
}
