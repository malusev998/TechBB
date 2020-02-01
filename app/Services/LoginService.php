<?php


namespace App\Services;


use App\Models\User;
use App\Contracts\Hasher;
use App\Contracts\LoginContract;
use App\Exceptions\InvalidCredentialsException;

class LoginService implements LoginContract
{
    private Hasher $hasher;

    /**
     * LoginService constructor.
     *
     * @param  \App\Contracts\Hasher  $hasher
     */
    public function __construct(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }


    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \App\Exceptions\InvalidCredentialsException
     * @throws \Throwable
     *
     * @param  array  $data
     *
     * @return array
     */
    public function login(array $data): array
    {
        ['email' => $email, 'password' => $password] = $data;

        $user = User::query()
            ->where('email', $email)
            ->firstOrFail();

        if(!$this->hasher->verify($user->password, $password)) {
            throw new InvalidCredentialsException();
        }

        if($this->hasher->needsRehash($user->password)) {
            $user->password = $this->hasher->hash($password);
            $user->saveOrFail();
        }

        return [
            'token' => '',
            'expires' => '',
            'type' => 'Bearer'
        ];
    }
}
