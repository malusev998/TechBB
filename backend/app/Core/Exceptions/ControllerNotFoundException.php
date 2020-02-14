<?php


namespace App\Core\Exceptions;


use Exception;
use Throwable;

class ControllerNotFoundException extends Exception
{
    public function __construct($message = 'Controller class is not found', $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
