<?php


namespace App\Tests\Services\Jwt;


use App\Services\Jwt\JwtSubject;

class TestSubject implements JwtSubject
{

    public function getIdentifier()
    {
        return 1;
    }

    public function getCustomClaims(): array
    {
        return [
            'name'    => 'Test',
            'surname' => 'Test',
            'email'   => 'test@test.com',
            'role'    => 'user',
        ];
    }
}
