<?php


namespace App\Core;


use Closure;
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

    private Environment $env;

    public function __construct(string $prefix = '/')
    {
        $routes = new RouteCollection();
        $this->env = new Environment();
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
        $containerBuilder->useAutowiring(true);
        $containerBuilder->useAnnotations(false);

        $directory = __DIR__ . '/../../config';

        $files = scandir($directory);


        foreach ($files as $file) {
            if (preg_match('#\.php$#', $file)) {
                $path = $directory . DIRECTORY_SEPARATOR . $file;
                $deps = require $path;
                $containerBuilder
                    ->addDefinitions($deps);
            }
        }

        return $containerBuilder->build();
    }

    private function route(): array
    {
        $this->handle();
        return $this->router->handle();
    }

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

        $controllerInstance = (new ControllerResolver($controller, $data['request']))
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

    public function setEnvironment(string $env): Kernel
    {
        $this->env->setEnv($env);
        return $this;
    }

    public function setCustomEnvironmentHandler(Closure $closure): Kernel
    {
        $this->env->setCustomHandler($closure);
        return $this;
    }

    abstract protected function handle();
}
