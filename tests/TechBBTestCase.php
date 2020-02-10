<?php


namespace App\Tests;


use Exception;
use Monolog\Test\TestCase;
use BrosSquad\DotEnv\EnvParser;
use Psr\Container\ContainerInterface;

class TechBBTestCase extends TestCase
{
    protected array $envs = [];

    protected ?ContainerInterface $container = null;

    protected function setUp(): void
    {
        $dotnev = new EnvParser(__DIR__.'/../.env.testing');

        $kernel = new TestKernel();

        try {
            $dotnev->parse();
            $dotnev->loadIntoENV();
            $this->envs = $dotnev->getEnvs();
            $this->container = $kernel->run();
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
