<?php


namespace App\Core\Exceptions;


use Exception;
use Throwable;

class IoCContainerException extends Exception
{
    public function __construct($message = 'Cannot create object', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
