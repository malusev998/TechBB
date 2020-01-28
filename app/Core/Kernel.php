<?php


namespace App\Core;

use DI\ContainerBuilder;
use App\Core\Parser\ActionParser;
use Psr\Container\ContainerInterface;
use App\Core\Resolvers\ActionResolver;
use App\Core\Formatters\BasicFormatter;
use App\Core\Resolvers\ControllerResolver;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;


abstract class Kernel
{
    protected Router $router;

    protected string $controllerNamespace = 'App\\Controllers\\';

    protected string $controllerDelimiter = '@';

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

//        if()
//        {
//
//        }

        return $containerBuilder->build();
    }

    private function route(): array
    {
        $this->handle();
        return $this->router->handle();
    }


    abstract protected function handle();

    /**
     * @throws \App\Core\Exceptions\ControllerNotFoundException
     * @throws \Throwable
     */
    final public function run(): void
    {
        $container = $this->injection();
        $data = $this->route();

        [$controller, $action] = (new ActionParser($this->controllerNamespace, $this->controllerDelimiter))
            ->parse($data['controller']);

        $controllerInstance = (new ControllerResolver($controller))
            ->resolve($container);
        ob_start();
        $response = (new ActionResolver($controllerInstance, $action, $data['request'], $data['params']))
            ->resolve($container);
        $response = (new BasicFormatter($data['request']))->format($response);

        if ($response !== null) {
            echo $response;
            return;
        }
        // Output the buffer
        Response::closeOutputBuffers(10, true);
    }
}
