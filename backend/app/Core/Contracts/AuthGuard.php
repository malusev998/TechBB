<?php


namespace App\Core\Contracts;


use Symfony\Component\HttpFoundation\Request;

interface AuthGuard
{
    public function authenticate(Request $request): ?Request;
}
