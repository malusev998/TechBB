<?php


namespace App\Services\Jwt;


interface JwtSubject
{
    public function getIdentifier();

    public function getCustomClaims(): array;
}
