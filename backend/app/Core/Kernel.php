<?php


namespace App\Core;


use Closure;
use Throwable;
use DI\ContainerBuilder;
use ReflectionException;
use App\Core\Http\Pipeline;
use App\Core\Exceptions\Handler;
use App\Core\Parser\ActionParser;
use Psr\Container\ContainerInterface;
use App\Core\Resolvers\ActionResolver;
use App\Core\Formatters\BasicFormatter;
use App\Core\Resolvers\ControllerResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Response;


abstract class Kernel
{
    protected Router $router;

    protected string $controllerNamespace = 'App\\Controllers\\';

    protected string $controllerDelimiter = '@';

    private Environment $env;

    private Pipeline $pipeline;

    private string $prefix;

    public function __construct(string $prefix = '/')
    {
        $this->env = new Environment();
        $this->pipeline = new Pipeline();
        $this->prefix = $prefix;
    }

    /**
     *
     * @throws \Exception
     * @return \Psr\Container\ContainerInterface
     */
    final protected function injection(): ContainerInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->useAnnotations(false);

        if (getApplicationEnvironment() === 'production') {
            $containerBuilder->enableDefinitionCache(__DIR__.'/../../.cache/php_di_cache');
        }

        $directory = __DIR__.'/../../config';

        $files = scandir($directory);


        foreach ($files as $file) {
            if (preg_match('#\.php$#', $file)) {
                $path = $directory.DIRECTORY_SEPARATOR.$file;
                $deps = require $path;
                $containerBuilder
                    ->addDefinitions($deps);
            }
        }

        return $containerBuilder->build();
    }

    private function route(): array
    {
        $this->boot();
        return $this->router->handle();
    }

    /**
     * @return void
     */
    public function run()
    {
        try {
            $container = $this->injection();
            $routes = new RouteCollection();
            $routes->addPrefix($this->prefix);
            $routes->addNamePrefix('');
            $this->router = new Router($routes, $this->pipeline, $container);

            $data = $this->route();

            [$controller, $action] = (new ActionParser($this->controllerNamespace, $this->controllerDelimiter))
                ->parse($data['controller']);

            $controllerInstance = (new ControllerResolver($controller, $data['request']))
                ->resolve($container);
            ob_start();
            $response = (new ActionResolver(
                $controllerInstance,
                $data['prefix'],
                $action,
                $data['request'],
                $this->pipeline,
                $data['params']
            ))
                ->resolve($container);
            $response = (new BasicFormatter($data['request']))->format($response);
        } catch (
        Exceptions\ControllerNotFoundException |
        Exceptions\IoCContainerException |
        Exceptions\ValidationException |
        ReflectionException |
        Throwable $e
        ) {
            $request = $data['request'] ?? (Request::createFromGlobals());
            $response = (new Handler($container, $request))->handle($e);
            $response = (new  BasicFormatter($request))->format($response);
        }
        finally {
            if (isset($response)) {
                echo $response;
                return;
            }
            Response::closeOutputBuffers(10, true);
        }
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

    abstract protected function boot();
}
