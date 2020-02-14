<?php


namespace App\Core\Resolvers;

use Throwable;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerResolver implements Resolver
{
    protected string $controller;
    protected Request $request;
    public function __construct(string $controller, Request $request)
    {
        $this->controller = $controller;
        $this->request = $request;
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
