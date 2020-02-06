<?php


namespace App\Core\Contracts;


use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface ExceptionHandlerInterface
{
    public function handle(Request $request, Throwable $e): Response;
}
