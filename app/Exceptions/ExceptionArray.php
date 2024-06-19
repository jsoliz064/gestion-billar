<?php

namespace App\Exceptions;

use Exception;

class ExceptionArray extends Exception
{
    protected $errors;

    public function __construct($message, $code = 400, $errors = [],  Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
