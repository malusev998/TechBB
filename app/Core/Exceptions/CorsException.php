<?php


namespace App\Core\Exceptions;


use Exception;
use Throwable;

class CorsException extends Exception
{
    public function __construct($message = 'Cross origin resource sharing exception', $code = 0, Throwable $previous =
    null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
