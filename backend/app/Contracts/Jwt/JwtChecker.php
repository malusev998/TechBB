<?php

namespace App\Contracts\Jwt;

use ProxyManager\Signature\Exception\InvalidSignatureException;

interface JwtChecker
{
    /**
     * Check Json Web Token validity
     *
     * @throws InvalidSignatureException
     * @throws \Throwable
     *
     * @param  string  $token
     *
     * @return array
     */
    public function check(string $token): array;
}
