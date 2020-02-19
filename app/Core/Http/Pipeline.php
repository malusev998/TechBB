<?php


namespace App\Core\Http;


use Closure;
use SplQueue;
use App\Core\Contracts\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Pipeline implements Middleware
{
    protected SplQueue $middleware;

    public function __construct()
    {
        $this->middleware = new SplQueue();
    }

    public function addMiddleware(Middleware $middleware): Pipeline
    {
        $this->middleware->enqueue($middleware);
        return $this;
    }


    public function handle(Request $request, Closure $next)
    {
        if ($this->middleware->isEmpty()) {
            return $next($request);
        }

        $response = null;
        $current = $this->middleware->dequeue();

        $response = $current->handle(
            $request,
            Closure::bind(
                function ($request) use ($next) {
                    return $this->handle($request, $next);
                },
                $this
            )
        );

        if ($response instanceof Response) {
            return $response;
        }

        return $response;
    }
}