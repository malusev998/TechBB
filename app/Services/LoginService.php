<?php


namespace App\Services;


use App\Contracts\Hasher;
use App\Contracts\LoginContract;

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


    public function login(array $data)
    {
    }
}
