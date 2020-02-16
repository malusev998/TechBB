<?php


namespace App\Middleware;


use Closure;
use App\Core\Contracts\Middleware;
use Psr\Container\ContainerInterface;
use App\Core\Exceptions\CorsException;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use function dd;
use function header;
use function in_array;
use function array_flip;

class CorsMiddleware implements Middleware
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function handle(Request $request, Closure $next)
    {
        $origins = $this->container->get('allowed_origins');
        $methods = $this->container->get('allowed_methods');
        $headers = $this->container->get('allowed_headers');
        $maxAge = $this->container->get('max_age');

        if (!isset($origins[0])) {
            $origins[0] = '*';
        }

        $validMethod = ($methods[0] !== '*' && !in_array($request->getMethod(), $methods, true));

        if ($validMethod || ($origins[0] !== '*' && !in_array
                (
                    $request->getSchemeAndHttpHost(),
                    $origins,
                    true
                ))) {
            throw new CorsException();
        }


        if ($request->isMethod('OPTIONS')) {
            $this->setHeader(
                [
                    'Access-Control-Allow-Origin'  => $origins,
                    'Access-Control-Allow-Methods' => $methods,
                    'Access-Control-Allow-Headers' => $headers,
                    'Access-Control-Max-Age'       => $maxAge,
                ]
            );
            exit();
        }


        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set('Access-Control-Allow-Origin', $origins);
            $response->headers->set('Access-Control-Allow-Methods', $methods);
            $response->headers->set('Access-Control-Allow-Headers', $headers);
            $response->headers->set('Access-Control-Max-Age', $maxAge);
        }

        return $response;
    }

    private function setHeader(array $values)
    {
        foreach ($values as $header => $headerValues) {
            foreach ($headerValues as $value) {
                header("{$header}: {$value}", false);
            }
        }
    }
}
