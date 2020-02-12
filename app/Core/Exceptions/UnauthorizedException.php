<?php


namespace App\Core\Exceptions;


use Exception;
use Throwable;

class UnauthorizedException extends Exception
{
    public function __construct($message = 'User is not authenticated', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
