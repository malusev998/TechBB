<?php


namespace App\Services\Auth;


use Carbon\Carbon;
use App\Models\User;
use App\Contracts\Hasher;
use App\Dto\Auth\RegisterDto;
use App\Contracts\Auth\RegisterContract;
use App\Exceptions\UserAlreadyExistsException;

class RegisterService implements RegisterContract
{
    protected Hasher $hasher;
    protected RoleService $roleService;

    /**
     * RegisterService constructor.
     *
     * @param  \App\Contracts\Hasher  $hasher
     * @param  \App\Services\Auth\RoleService  $roleService
     */
    public function __construct(Hasher $hasher, RoleService $roleService)
    {
        $this->hasher = $hasher;
        $this->roleService = $roleService;
    }


    /**
     * @throws \App\Exceptions\UserAlreadyExistsException
     * @throws \Throwable
     *
     * @param  \App\Dto\Auth\RegisterDto  $data
     *
     * @param  string  $role
     *
     * @return \App\Models\User
     */
    public function register(RegisterDto $data, string $role = 'user'): User
    {
        $userExists = User::query()->where('email', $data['email'])->exists();

        if ($userExists) {
            throw new UserAlreadyExistsException();
        }

        $user = new User(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'surname' => $data['surname'],
                'password' => $this->hasher->hash($data['password']),
                'email_verified_at' => Carbon::now('UTC'),
                'role_id' => $this->roleService->getRole($role)->id
            ]
        );

        $user->saveOrFail();

        // TODO: Send verification email

        return $user;
    }
}
