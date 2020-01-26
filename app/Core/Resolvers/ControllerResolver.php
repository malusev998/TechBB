<?php


namespace App\Core\Resolvers;

use Throwable;
use Psr\Container\ContainerInterface;

class ControllerResolver implements Resolver
{
    protected string $controller;

    public function __construct(string $controller)
    {
        $this->controller = $controller;
    }

    public function resolve(ContainerInterface $container): object
    {
        try {
            return $container->get($this->controller);
        } catch (Throwable $e) {
            return null;
        }
    }
}
