<?php


namespace App\Core\Exceptions;


use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected array $errors;

    public function __construct(array $errors, int $code = 422)
    {
        parent::__construct('', $code, null);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}
