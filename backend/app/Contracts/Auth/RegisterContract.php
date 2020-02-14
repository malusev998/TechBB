<?php


namespace App\Contracts\Auth;


use App\Models\User;
use App\Dto\Auth\RegisterDto;

interface RegisterContract
{
    public function register(RegisterDto $data, string $role = 'user'): User;
}
