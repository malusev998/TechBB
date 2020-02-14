<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class InvalidCredentialsException extends Exception
{
    public function __construct($message = 'Email or password are incorrect', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
