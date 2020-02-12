<?php


namespace App;


use App\Core\Contracts\PermissionResolver;
use Symfony\Component\HttpFoundation\Request;

class RoleResolver implements PermissionResolver
{
    public function resolve(Request $request, array $permissions = []): bool
    {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get('user');
        return in_array($user->role->name, $permissions, true);
    }

}
