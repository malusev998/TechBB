<?php


namespace App\Core\Contracts;


use Closure;
use Symfony\Component\HttpFoundation\Request;

interface Middleware
{
    public function handle(Request $request, Closure $next);
}
