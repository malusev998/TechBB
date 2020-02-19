<?php


namespace App\Core;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\PhpFileLoader;

use Symfony\Component\HttpFoundation\Request;

class Router
{
    protected RouteCollection $routes;

//    protected static array $reservedKeys = ['_controller' => 1, '_route' => 2];

    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function addRoutes(string $file, string $prefix = '', string $namePrefix = ''): Router
    {
        $fileLocator = new FileLocator([__DIR__.'/../../routes']);

        $phpFileLoader = new PhpFileLoader($fileLocator);
        $collection = $phpFileLoader->load($file);
        $collection->addPrefix($prefix);
        $collection->addNamePrefix($namePrefix);
        $this->routes->addCollection($collection);

        return $this;
    }


    public function api(): Router
    {
        return $this->addRoutes('api.php', 'api', 'api-');
    }

    public function web(): Router
    {
        return $this->addRoutes('web.php', '', '');
    }


    public function handle(): array
    {
        $request = Request::createFromGlobals();
        $context = (new RequestContext())
            ->fromRequest($request);

        $data = (new UrlMatcher($this->routes, $context))->matchRequest($request);
        $controller = $data['_controller'];
        $route = $data['_route'];

        unset($data['_controller'], $data['_route']);


        return [
            'params'          => $data,
            'controller'      => $controller,
            'route'           => $route,
            'request'         => $request,
            'request_context' => $context,
        ];
    }

}