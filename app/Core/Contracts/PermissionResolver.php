<?php


namespace App\Core\Contracts;


use Symfony\Component\HttpFoundation\Request;

interface PermissionResolver
{
    public function resolve(Request $request, array $permissions = []): bool;
}
