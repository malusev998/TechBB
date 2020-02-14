<?php


namespace App\Core\Resolvers;


use Psr\Container\ContainerInterface;

interface Resolver
{
    public function resolve(ContainerInterface $container);
}
