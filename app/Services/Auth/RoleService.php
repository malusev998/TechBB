<?php


namespace App\Services\Auth;


use App\Models\Role;
use App\Core\Redis\Redis;

class RoleService
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param  string|integer  $nameOrId
     *
     * @return bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|string
     */
    public function getRole($nameOrId)
    {
        $redisConnection = $this->redis->getConnection();

        if ($redisConnection->exists($nameOrId)) {
            return $redisConnection->get($nameOrId);
        }

        if (is_string($nameOrId)) {
            $searchBy = 'name';
        } elseif (is_int($nameOrId)) {
            $searchBy = 'id';
        } else {
            throw new \TypeError('$nameOrId can be string or integer');
        }

        $role = Role::query()->where($searchBy, $nameOrId)->firstOrFail();

        $redisConnection->setex($nameOrId, 3600, $role);

        return $role;
    }

    public function getAllRoles()
    {
        $redisConnection = $this->redis->getConnection();

        if (($roles = $redisConnection->get('roles'))) {
            return $roles;
        }

        $roles = Role::all();

        foreach ($roles as $role) {
            $redisConnection->set($role->name, 3600, $role);
        }

        $redisConnection->setEx('roles', 3600, $roles);

        return $roles;
    }
}
