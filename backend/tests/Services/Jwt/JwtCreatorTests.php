<?php


namespace App\Tests\Services\Jwt;


use Throwable;
use App\Tests\TechBBTestCase;
use App\Contracts\Jwt\JwtCreator;

class JwtCreatorTests extends TechBBTestCase
{

    /**
     * @beforeClass
     */
    public function testJwtCreation(): void
    {
        try {
            $jwtCreator = $this->container->get(JwtCreator::class);
            $this->assertNotNull($jwtCreator);
            $this->assertInstanceOf(JwtCreator::class, $jwtCreator);
        }catch (Throwable $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testTokenGeneration(): void
    {
        try {
            $testSubject = new TestSubject();
            $jwtCreator = $this->container->get(JwtCreator::class);
            $token = $jwtCreator->create($testSubject);
            $this->assertIsString($token);
            $this->assertCount(3, explode('.', $token));
            echo $token;
        }catch (Throwable $e) {
            $this->fail($e->getMessage());
        }
    }
}
