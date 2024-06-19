<?php

namespace App\Traits;

use App\Exceptions\ExceptionArray;

trait ResponseTrait
{
    public function ResponseError($message, $code, $errors = null)
    {
        $responseError['message'] = $message;
        $responseError['error'] = $code;
        if ($errors) {
            $responseError['errors'] = $errors;
        }
        return response()->json($responseError, $code);
    }

    public function ResponseThrow(ExceptionArray $th)
    {
        $responseError['message'] = $th->getMessage();
        $responseError['error'] = $th->getCode();
        $errors = $th->getErrors();
        if ($errors) {
            $responseError['errors'] = $errors;
        }
        return response()->json($responseError, $th->getCode());
    }
}
