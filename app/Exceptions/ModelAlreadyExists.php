<?php


namespace App\Exceptions;


use Exception;
use Throwable;

class ModelAlreadyExists extends Exception
{
    public function __construct($message = '', $code = 422, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
