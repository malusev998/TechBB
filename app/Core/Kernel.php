<?php


namespace App\Core;


use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;

abstract class Kernel
{
    protected Router $router;

    public function __construct(string $prefix = '/')
    {
        $routes = new RouteCollection();
        $routes->addPrefix($prefix);
        $routes->addNamePrefix('');
        $this->router = new Router($routes);
    }

    /**
     *
     * @throws \Exception
     * @return \Psr\Container\ContainerInterface
     */
    private function injection(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();

        $deps = require __DIR__.'/../../config/dependency.php';

        $containerBuilder
            ->addDefinitions($deps)
            ->useAutowiring(true)
            ->useAnnotations(false);


        return $containerBuilder->build();
    }

    private function route()
    {
        $this->handle();
        return $this->router->handle();
    }


    abstract protected function handle();

    /**
     * @throws \Exception
     */
    final public function run()
    {
        $container = $this->injection();
        $data = $this->router->handle();
    }
}
