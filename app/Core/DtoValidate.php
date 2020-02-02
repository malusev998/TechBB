<?php


namespace App\Core;


use Rakit\Validation\Validator;
use Psr\Container\ContainerInterface;
use App\Core\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Request;

class DtoValidate
{
    protected ContainerInterface $container;
    protected Request $request;

    public function __construct(ContainerInterface $container, Request $request) {
        $this->container = $container;
        $this->request = $request;
    }

    /**
     * @throws \App\Core\Exceptions\ValidationException
     *
     * @param  string  $class
     *
     * @return \App\Core\BaseDto
     */
    public function validate(string $class): BaseDto
    {
        // Check if content type begins with application/json
        if (strpos($this->request->getContentType(), 'application/json') === 0) {
            $data = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            $data = $_POST;
        }

        $data += $_FILES;

        $validator = $this->container->get(Validator::class);

        /** @var BaseDto $dto */
        $dto = new $class($data);

        $validation = $validator->make($data, $dto->validate(), $dto->validationMessages());
        $validation->validate();

        if($validation->fails()) {
            throw new ValidationException($validation->errors()->firstOfAll());
        }

        return $dto;
    }
}

