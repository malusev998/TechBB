<?php


namespace App\Core\Http;


use Closure;
use SplQueue;
use RuntimeException;
use App\Core\Contracts\Middleware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Pipeline implements Middleware
{


    protected array $middleware = [];

    protected string $handleQueue = '';

    public function __construct()
    {
    }

    public function addMiddleware(string $name, Middleware $middleware): Pipeline
    {
        $this->initQueue($name);
        $this->middleware[$name]->enqueue($middleware);
        return $this;
    }


    public function handle(Request $request, Closure $next)
    {
        /** @var SplQueue $middlewareStack */
        $middlewareStack = $this->middleware[$this->handleQueue];

        if (!isset($middlewareStack)) {
            throw new RuntimeException("{$this->handleQueue} is not set");
        }

        if ($middlewareStack->isEmpty()) {
            return $next($request);
        }

        $current = $middlewareStack->dequeue();

        $response = $current->handle(
            $request,
            Closure::bind(fn($request) => $this->handle($request, $next), $this)
        );


        if ($response instanceof Response) {
            return $response;
        }

        return $response;
    }

    public function handleQueue(string $queue): Pipeline
    {
        $this->handleQueue = $queue;
        return $this;
    }

    /**
     * @param  string  $name
     *
     * @return \App\Core\Http\Pipeline
     */
    public function initQueue(string $name): Pipeline
    {
        if (!isset($this->middleware[$name])) {
            $this->middleware[$name] = new SplQueue();
        }

        return $this;
    }
}
