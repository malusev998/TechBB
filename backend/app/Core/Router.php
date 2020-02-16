<?php


namespace App\Core;

use App\Core\Http\Pipeline;
use Psr\Container\ContainerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\PhpFileLoader;

use Symfony\Component\HttpFoundation\Request;

use function is_string;
use function preg_match;

class Router
{
    protected RouteCollection $routes;

    protected ContainerInterface $container;

    protected Pipeline $pipeline;

    protected array $namePrefixes = [];

    public function __construct(RouteCollection $routes, Pipeline $pipeline, ContainerInterface $container)
    {
        $this->routes = $routes;
        $this->pipeline = $pipeline;
        $this->container = $container;
    }

    public function addRoutes(
        string $file,
        string $prefix = '',
        string $namePrefix = '',
        array $middleware = []
    ): Router {
        $this->pipeline->initQueue($namePrefix);

        foreach ($middleware as $m) {
            $this->pipeline->addMiddleware($namePrefix, is_string($m) ? $this->container->get($m) : $m);
        }

        if (!isset($this->namePrefixes[$namePrefix])) {
            $this->namePrefixes[$namePrefix] = $namePrefix;
        }

        $fileLocator = new FileLocator([__DIR__.'/../../routes']);

        $phpFileLoader = new PhpFileLoader($fileLocator);
        $collection = $phpFileLoader->load($file);
        $collection->addPrefix($prefix);
        $collection->addNamePrefix($namePrefix);
        $this->routes->addCollection($collection);

        return $this;
    }


    public function api(array $middleware = []): Router
    {
        return $this->addRoutes('api.php', 'api', 'api-', $middleware);
    }

    public function web(array $middleware = []): Router
    {
        return $this->addRoutes('web.php', '', 'web-', $middleware);
    }


    public function handle(): array
    {
        $request = Request::createFromGlobals();
        $context = (new RequestContext())
            ->fromRequest($request);

        $urlMatcher = new UrlMatcher($this->routes, $context);
        $data = $urlMatcher->matchRequest($request);
        $controller = $data['_controller'];
        $route = $data['_route'];

        $prefix = '';
        foreach ($this->namePrefixes as $p) {
            if (preg_match("#^{$p}#", $route)) {
                $prefix = $p;
                break;
            }
        }

        unset($data['_controller'], $data['_route']);


        return [
            'params'          => $data,
            'controller'      => $controller,
            'route'           => $route,
            'prefix'          => $prefix,
            'request'         => $request,
            'request_context' => $context,
        ];
    }

}
