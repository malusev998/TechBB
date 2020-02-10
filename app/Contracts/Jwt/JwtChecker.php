<?php

namespace App\Contracts\Jwt;

interface JwtChecker
{
    /**
     * @param  string  $token
     *
     * @return mixed
     */
    public function check(string $token);
}
