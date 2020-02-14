<?php


namespace App\Core\Exceptions;


use Throwable;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

use function dump;

class Handler
{

    protected ContainerInterface $container;
    protected ?Request $request;

    public function __construct(ContainerInterface $container, ?Request $request)
    {
        $this->container = $container;
        if ($request === null) {
            $this->request = Request::createFromGlobals();
        } else {
            $this->request = $request;
        }
    }

    public function customExceptionHandler(Throwable $e): ?Response
    {
        $handlers = $this->container->get('error_handlers');
        if (isset($handlers[get_class($e)])) {
            /** @var \App\Core\Contracts\ExceptionHandlerInterface $instance */
            $instance = $this->container->get($handlers[get_class($e)]);

            return $instance->handle($this->request, $e);
        }

        return null;
    }

    public function handle(Throwable $e): ?Response
    {
        // Custom exception handlers
        if ($this->container->has('error_handlers') && ($res = $this->customExceptionHandler($e)) !== null) {
            return $res;
        }

        if ($e instanceof CorsException) {
            return $this->handleResponse(Response::HTTP_BAD_REQUEST, ['message' => $e->getMessage()]);
        }

        if ($e instanceof UnauthenticatedException) {
            return $this->handleResponse(Response::HTTP_UNAUTHORIZED, ['message' => $e->getMessage()]);
        }

        if ($e instanceof UnauthorizedException) {
            return $this->handleResponse(Response::HTTP_FORBIDDEN, ['message' => $e->getMessage()]);
        }

        // Route not found exception
        if ($e instanceof ResourceNotFoundException ||
            $e instanceof NotFoundResourceException ||
            $e instanceof ControllerNotFoundException) {
            return $this->handleResponse(Response::HTTP_NOT_FOUND, ['message' => 'Page is not found']);
        }

        // Validation exception
        if ($e instanceof ValidationException) {
            return $this->handleResponse(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                [
                    'errors' => $e->getErrors(),
                ]
            );
        }

        dump($e);
        // Any other exception
        return $this->handleResponse(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            [
                'message' => $_ENV['APP_ENVIRONMENT'] === 'development' ? $e->getMessage() : 'An error has occurred',
            ]
        );
    }

    private function handleResponse(int $status, $data, $headers = []): ?Response
    {
        $accept = $this->request->getAcceptableContentTypes();
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'text/html';
        }
        if (is_array($data) || in_array('application/json', $accept, true)) {
            $data = json_encode($data, JSON_THROW_ON_ERROR, 512);
            $headers['Content-Type'] = 'application/json';
        }

        return new Response($data, $status, $headers);
    }
}
