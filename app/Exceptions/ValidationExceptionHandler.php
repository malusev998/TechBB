<?php


namespace App\Exceptions;


use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Contracts\ExceptionHandlerInterface;

class ValidationExceptionHandler implements ExceptionHandlerInterface
{

    public function handle(Request $request, Throwable $e): Response
    {
    }
}
