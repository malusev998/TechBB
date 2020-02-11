<?php


namespace App\Contracts\Auth;


use App\Dto\Auth\LoginDto;

interface LoginContract
{
    public function login(LoginDto $data);
}
