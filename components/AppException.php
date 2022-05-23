<?php

namespace app\components;

use Exception;
use Throwable;

class AppException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null) {
        if($message && !$code) {
            $code = AppErrors::getStatusCode($message);
        }
        parent::__construct($message, $code, $previous);
    }
}