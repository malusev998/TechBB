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

        if($this->middleware->isEmpty()) {
            return $next($request);
        }

        $nextCopy = clone $next;

        $response = null;

        while (!$this->middleware->isEmpty()) {
            $current = $this->middleware->dequeue();
            $next = $this->middleware->dequeue();

            $response = $current->handle(
                $request,
                $next instanceof Middleware ? Closure::fromCallable([$next, 'handle'])
                    : $nextCopy
            );

            if ($response instanceof Response) {
                return $response;
            }

            if ($response instanceof Request) {
                $request = $response;
            }
        }

        return $response;
    }
}
