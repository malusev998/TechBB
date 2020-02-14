<?php


namespace App\Controllers;


use Symfony\Component\HttpFoundation\Response;

abstract class ApiController
{
    protected function response($data, int $status, array $headers = []): Response
    {
        if (!isset($headers['Content-Type'])) {
            $headers['Content-Type'] = 'application/json';
        }
        if ($data === null) {
            $data = '';
        }

        $data = json_encode($data, JSON_THROW_ON_ERROR, 512);

        return Response::create($data, $status, $headers);
    }

    public function ok($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_OK, $headers);
    }

    public function created($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_CREATED, $headers);
    }

    public function noContent(array $headers = []): Response
    {
        return $this->response(null, Response::HTTP_NO_CONTENT, $headers);
    }

    public function badRequest($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_BAD_REQUEST, $headers);
    }

    public function unauthorized($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_UNAUTHORIZED, $headers);
    }

    public function forbidden($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_FORBIDDEN, $headers);
    }

    public function notFound($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_NOT_FOUND, $headers);
    }

    public function unprocessableEntity($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_UNPROCESSABLE_ENTITY, $headers);
    }

    public function serverError($data, array $headers = []): Response
    {
        return $this->response($data, Response::HTTP_INTERNAL_SERVER_ERROR, $headers);
    }

}
