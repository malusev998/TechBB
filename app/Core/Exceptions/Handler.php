<?php


namespace App\Core\Exceptions;


use Throwable;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\NoConfigurationException;

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


    public function handle(Throwable $e): ?Response
    {
        if ($e instanceof NoConfigurationException) {
            return $this->handleResponse(404, '');
        }

        if ($e instanceof ValidationException) {
            return $this->handleResponse(
                422,
                [
                    'errors' => $e->getErrors(),
                ]
            );
        }

        // TODO: Add support for custom error handlers

        return $this->handleResponse(500, ['message' => 'An Error has occurred']);
    }

    private function handleResponse(int $status, $data): ?Response
    {
        $accept = $this->request->getAcceptableContentTypes();
        if (in_array('application/json', $accept, true)) {
            return new Response(
                json_encode($data, JSON_THROW_ON_ERROR, 512), $status, [
                                                                'Content-Type' => 'application/json',
                                                            ]
            );
        }

        return new Response(
            $data, $status, [
                     'Content-Type' => 'text/html',
                 ]
        );
    }
}
