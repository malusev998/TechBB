<?php


namespace App\Tests\Services\Jwt;


use Throwable;
use App\Tests\TechBBTestCase;
use App\Contracts\Jwt\JwtChecker;
use App\Contracts\Jwt\JwtCreator;

class JwtCheckerTests extends TechBBTestCase
{

    /**
     * @beforeClass
     */
    public function testJwtCheckerCreation(): void
    {
        try {
            $jwtChecker = $this->container->get(JwtChecker::class);

            $this->assertNotNull($jwtChecker);
            $this->assertInstanceOf(JwtChecker::class, $jwtChecker);
        }catch (Throwable $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testCheckValidJsonWebToken(): void
    {
        $testSubject = new TestSubject();
        $jwtCreator = $this->container->get(JwtCreator::class);
        $token = $jwtCreator->create($testSubject);
        $jwtChecker = $this->container->get(JwtChecker::class);
        try {
            $res = $jwtChecker->check($token);

            $this->assertIsArray($res);

            $this->assertArrayHasKey('payload', $res);
            $this->assertArrayHasKey('validated_claims', $res);
        }catch (Throwable $e) {
            $this->fail($e->getMessage());
        }
    }
}
