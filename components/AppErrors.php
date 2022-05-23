<?php

namespace app\components;

class AppErrors
{
    public const INVALID_REQUEST = 'invalid_request';
    public const SYSTEM_FAULT = 'system_fault';

    public static function getText($state): string
    {
        switch ($state) {
            case self::INVALID_REQUEST:
                $message = 'Неверные параметры запроса';
                break;
            case self::SYSTEM_FAULT:
            default:
                $message = 'Непредвиденная ошибка';
        };

        return $message;
    }

    public static function getStatusCode($state): int
    {
        switch ($state) {
            case self::INVALID_REQUEST:
                $code = 400;
                break;
            case self::SYSTEM_FAULT:
            default:
                $code = 500;
        };

        return $code;
    }
}