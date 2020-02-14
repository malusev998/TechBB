<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class UserAlreadyExistsException extends Exception
{
    public function __construct($message = 'User already exists', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
