<?php


namespace App\Services\Auth;


use App\Models\User;
use App\Contracts\Hasher;
use App\Exceptions\UserAlreadyExistsException;

class RegisterService
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
     * @param  array  $data
     *
     * @return \App\Models\User
     */
    public function register(array $data): User
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
                'email_verified_at' => null,
                'role_id' => $this->roleService->getRole('user')->id
            ]
        );

        $user->saveOrFail();


        return $user;
    }
}
