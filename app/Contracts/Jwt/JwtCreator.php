<?php

namespace App\Contracts\Jwt;

use App\Services\Jwt\JwtSubject;

interface JwtCreator
{
    public function create(JwtSubject $user): string;
}
